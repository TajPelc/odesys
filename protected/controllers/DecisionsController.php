<?php
/**
 *
 * Blog controller
 * @author Taj
 *
 */
class DecisionsController extends Controller
{
    public function actionIndex() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/decisions/index.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/decisions/index.js');

        $this->render('list');
    }
}
