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
            $this->Decision->description = $this->post('description_new');
            if($this->Decision->validate(array('description')))
            {
                $this->Decision->save(false);
                $this->Decision->publishDecisionModel();


                // @TODO: Fix the URL problem
                $this->redirect('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html');
            }
        }

        // render the view
        $this->render('index', array(
            'errors' => $this->Decision->getErrors(),
        ));
    }
}