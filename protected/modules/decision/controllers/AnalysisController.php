<?php
/**
 * Analysis Controller
 *
 * @author Taj
 *
 */
class AnalysisController extends DecisionController
{
    // default action
    public $defaultAction = 'display';

    /**
     * Displays a particular model.
     */
    public function actionDisplay()
    {
        // redirect to evaluation if it's not yet complete
        if(!$this->DecisionModel->checkEvaluationComplete())
        {
            $this->redirect(array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label));
        }

        if(Ajax::isAjax())
        {
            // enable next step
            if($this->post('action') == 'enableSharing')
            {
                $this->DecisionModel->analysis_complete = 1;
                if( $this->DecisionModel->save() )
                {
                    Ajax::respondOk(array(
                        'projectMenu' => $this->getProjectMenu(),
                    ));
                }
            }
        }

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery.selectBox.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/score.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/abacon.js');

        //include style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/analysis/index.css');

        // get evaluation array
        $eval = $this->DecisionModel->getEvaluationArray();

        // find the best two alternatives by weighted score
        $criteria = new CDbCriteria();
        $criteria->addCondition('rel_model_id=:rel_model_id');
        $criteria->order = 'weightedScore DESC';
        $criteria->params = array('rel_model_id' => $this->DecisionModel->model_id);
        $bestAlternatives = Alternative::model()->findAll($criteria);

        $this->render('display',array(
            'eval'      => $eval,
            'bestAlternatives' =>  $bestAlternatives,
            'Alternatives'	=> $this->DecisionModel->alternatives,
        ));
    }
}