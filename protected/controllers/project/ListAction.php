<?php
/**
 * List all decisions
 *
 * @author Taj
 *
 */
class ListAction extends Action
{
    public function run()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/dashboard/list.css');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dashboard/list.js');

        // find all user's projects
        $Decisions = Decision::model()->findAllByAttributes(array('rel_user_id' => Yii::app()->user->id), array('order' => 'last_edit DESC'));

        // render
        $this->render('list', array('Decisions' => $Decisions));
    }
}