<?php
/**
 * Results Controller
 *
 * @author Taj
 *
 */
class ResultsController extends Controller
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

        // graph data
        $eval = $Project->getEvaluationArray(true);
        $rv = array();
        foreach($eval as $Alternative)
        {
            $val = array();
            $rv['nrCriteria'] = count($Alternative['Criteria']);
            $rv['legend'][] = CHtml::encode(Common::truncate($Alternative['Obj']->title, 25));

            $i = count($Alternative['Criteria']);
            foreach($Alternative['Criteria'] as $Criteria)
            {
                $val[] = array((int)$Criteria['Evaluation']->grade * 10, CHtml::encode($Criteria['Obj']->title));
                $i--;
            }

            $rv['data'][] = $val;
        }
        $rv['colorPool'] = self::$colorPool;

        // calculate scores for each alternative
        $total = array();
        $max = array(0);
        foreach($Project->getEvaluationArray(true) as $A)
        {
            $i = 100;
            $score = 0;
            foreach($A['Criteria'] as $C)
            {
                $score = $score + ( $i * $C['Evaluation']->grade );
                $i = 0.85 * $i;
            }
            if($score > current($max))
            {
                $max = array($A['Obj']->alternative_id => $score);
            }
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/jquery.jqplot.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.categoryAxisRenderer.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.highlighter.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.cursor.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/graph.js');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/js/jqplot/jquery.jqplot.css');

        $this->render('display',array(
            'rv'      => $rv,
            'Project' => $Project,
            'max'     => $max,
            'colorPool' => self::$colorPool,
        ));
    }
}