<?php
/**
 * Alternative controller
 *
 * @author Taj
 *
 */
class SharingController extends DecisionController
{
    /**
     * Index page
     */
    public function actionIndex()
    {
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/dropdown.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/sharing/index.css');

        // add style files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/sharing/index.js');

        // redirect to criteria create if evaluation conditions not set
        if(!$this->DecisionModel->checkAnalysisComplete())
        {
            $this->redirect(array('/decision/analysis', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label));
        }
        // post
        if($this->post('publish'))
        {
            // set values
            $this->Decision->description = $this->post('description_new');
            $this->Decision->view_privacy = $this->post('privacy_decision');
            $this->Decision->opinion_privacy = $this->post('privacy_comments');
            $this->DecisionModel->preferred_alternative = $this->post('preff_alt');

            // validate description
            if($this->Decision->validate(array('description', 'view_privacy', 'opinion_privacy')))
            {
                $this->DecisionModel->save();
                $this->Decision->save(false);

                // share to facebook
                if($this->post('facebook_share'))
                {
                    $this->_shareToFacebook();
                }

                // publish
                $this->Decision->publishDecisionModel();


                // @TODO: Fix the URL problem
                $this->redirect($this->publicLink);
            }

        }

        // render the view
        $this->render('index', array(
            'errors' => $this->Decision->getErrors(),
        ));
    }


    /**
     * Publish the current active decision model and create a new active decision model
     */
    private function _shareToFacebook()
    {
        // do not save if decision is private or already published
        if($this->Decision->view_privacy == Decision::PRIVACY_ME || $this->Decision->isPublished() || Yii::app()->params['fbDisableSharing'])
        {
            return;
        }
        try
        {

            // post to facebook
            $facebook = Fb::singleton();
            $facebook->api("/".$facebook->getUser()."/feed", 'post', array(
                'picture' => 'http://dl.dropbox.com/u/1814846/KURAC.png',
                'message' => 'created a new decision model on ODESYS',
                'link'    => Common::getBaseURL().$this->publicLink,
                'name' => CHtml::encode($this->Decision->title),
                'caption' => CHtml::encode(Common::truncate($this->Decision->description, 900)),
                )
            );
        }
        catch (Exception $e)
        {
            Yii::log($e->getMessage(), 'warning');
        }
    }
}
