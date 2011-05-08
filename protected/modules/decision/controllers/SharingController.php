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
}