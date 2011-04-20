<?php
/**
 * Analysis Controller
 *
 * @author Taj
 *
 */
class AnalysisController extends DecisionController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionDisplay()
    {
        // load active project
        $Project = $this->loadActiveProject();

        // redirect to evaluation if it's not yet complete
        if(!$Project->checkEvaluationComplete())
        {
            $this->redirect(array('evaluation/evaluate'));
        }

        /**
         * @TODO Move this code to the last page
         */
        User::current()->setConfig('help', false);

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

        $eval = $Project->getEvaluationArray();

        // find two last projects by weighted score
        $criteria = new CDbCriteria();
        $criteria->addCondition('rel_project_id=:rel_project_id');
        $criteria->order = 'weightedScore DESC';
        $criteria->params = array('rel_project_id' => $Project->project_id);
        $bestAlternatives = Alternative::model()->findAll($criteria);

        $this->render('display',array(
            'eval'      => $eval,
            'bestAlternatives' =>  $bestAlternatives,
            'Project'   => $Project,
            'Alternatives'	=> $Project->alternatives,
        ));
    }
}