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
        /**
         * @TODO Move this code to the last page
         */
        User::current()->setConfig('help', false);

        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/sharing/index.css');

        // add style files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/sharing/index.js');

        // render the view
        $this->render('index');
    }
}