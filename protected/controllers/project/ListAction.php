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
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/dashboard/list.css');

        // find all user's projects
        $Decisions = Project::model()->findAllByAttributes(array('rel_user_id' => Yii::app()->user->id));

        // render
        $this->render('list', array('Decisions' => $Decisions));
    }
}