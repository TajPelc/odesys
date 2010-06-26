<?php

class EvaluationController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to 'column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='column1';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionEvaluate()
    {
        // load active project
        $Project = $this->loadActiveProject();

        // get eval array
        $eval = $Project->getEvaluationArray();

        // evaluate!
        if(isset($_POST['eval']))
        {
            // alternatives loop
            foreach($_POST['eval'] as $alternativeId => $evals)
            {
                // criteria loop
                foreach($evals as $criteriaId => $grade)
                {
                    // check if the evaluation already exists and update it
                    $Evaluation = $eval[$alternativeId]['Criteria'][$criteriaId]['Evaluation'];
                    $Evaluation->rel_project_id = $Project->project_id;
                    $Evaluation->rel_alternative_id = $alternativeId;
                    $Evaluation->rel_criteria_id = $criteriaId;
                    $Evaluation->grade = $grade;
                    $Evaluation->save();
                }
            }

            $this->redirect(array('results/display'));
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluation.js');

        $this->render('evaluate',array(
            'Project'   => $Project,
            'eval'      => $eval,
        ));
    }

    /**
     * Deletes an evaluation
     */
    public function actionDelete()
    {
        $this->loadModel('criteria')->delete();
        $this->redirect(array('create'));
    }
}
