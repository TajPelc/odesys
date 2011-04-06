<?php
/**
 * Results Controller
 *
 * @author Taj
 *
 */
class ResultsController extends DecisionController
{
    /**
     * Color pool for plotting graphs
     *
     * @var array
     */
    private static $colorPool = array(
        "#5c0369",
        "#6ac616",
        "#eb8e94",
        "#c6dc0c",
        "#d4a460",
        "#2da7b9",
        "#b000b7",
        "#18b3f7",
        "#bd3439",
        "#00953f"
    );

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

        // graph data
        $eval = $Project->getEvaluationArray();
        $rv = array('colorPool' => self::$colorPool);
        foreach($eval as $Alternative)
        {
            $scores = array();
            $weightedScores = array();
            $weights = array();
            $rv['nrCriteria'] = count($Alternative['Criteria']);
            $rv['legend'][] = CHtml::encode(Common::truncate($Alternative['Obj']->title, 25));

            $Alternative['Criteria'] = array_reverse($Alternative['Criteria'], true);
            foreach($Alternative['Criteria'] as $Criteria)
            {
                $scores[]           = array((int)$Criteria['score'],            CHtml::encode($Criteria['Obj']->title));
                $weightedScores[]   = array((int)$Criteria['weightedScore'],   CHtml::encode($Criteria['Obj']->title));
                $weights[CHtml::encode($Criteria['Obj']->title)] = $Criteria['weight'];
            }

            $rv['scores'][] = $scores;
            $rv['weightedScores'][] = $weightedScores;
            $rv['weights'][] = $weights;
            $rv['total'][] = $Alternative['total'];
            $rv['weightedTotal'][] = $Alternative['weightedTotal'];
        }

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jqplot/jquery.jqplot.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jqplot/plugins/jqplot.categoryAxisRenderer.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jqplot/plugins/jqplot.highlighter.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jqplot/plugins/jqplot.cursor.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jqplot/plugins/jqplot.canvasTextRenderer.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/results/graph.js');

        //include style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/js/core/jqplot/jquery.jqplot.css');

        $this->render('display',array(
            'rv'        => $rv,
            'Project'   => $Project,
            'colorPool' => self::$colorPool,
        ));
    }
}