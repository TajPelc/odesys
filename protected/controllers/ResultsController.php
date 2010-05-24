<?php

class ResultsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to 'column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='checkboxes';

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
     * Displays a particular model.
     */
    public function actionDisplay()
    {
        // load active project
        $Project = $this->loadActiveProject();

        // ajax request for graph data?
        if(Yii::app()->request->isAjaxRequest)
        {
            $eval = $Project->getEvaluationArray();
            $rv = array();

            foreach($eval as $Alternative)
            {
                $val = array();
                $rv['nrCriteria'] = count($Alternative['Criteria']);

                foreach($Alternative['Criteria'] as $Criteria)
                {
                    $val[] = array((int)$Criteria['Evaluation']->grade * 10, CHtml::encode($Criteria['Obj']->title));
                }

                $rv['legend'][] = CHtml::encode($Alternative['Obj']->title);
                $rv['data'][] = $val;
            }

            header('Content-type: application/json');
            echo json_encode($rv);
            exit();
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.4.2.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/jquery.jqplot.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.categoryAxisRenderer.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.highlighter.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.cursor.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.horizontalLegendRenderer.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/graph.js');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/js/jqplot/jquery.jqplot.css', 'text/css');

        $this->render('display',array(
            'Project' => $Project,
        ));
    }
}
