<?php
/**
 * Decision public page
 *
 * @author Taj
 *
 */
class PublicAction extends Action
{
    public function run()
    {
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/public/index.css');
        $this->render('public');
    }
}