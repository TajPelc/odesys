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
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/decision/index.css');

        $this->render('list');
    }
}
