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

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery.selectBox.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael-min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/graph.js');

        //include style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/analysis/index.css');

        $this->render('display',array(
            'eval'      => $Project->getEvaluationArray(),
            'Project'   => $Project,
            'colorPool' => self::$colorPool,
        ));
    }
}