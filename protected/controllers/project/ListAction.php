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
        // ajax
        if(Ajax::isAjax())
        {
            if($this->post('delete'))
            {
                $this->_delete($this->post('delete'));
            }
        }

        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/dashboard/list.css');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dashboard/list.js');

        // find all user's projects
        $Decisions = Decision::model()->findAllByAttributes(array('rel_user_id' => Yii::app()->user->id, 'deleted' => 0), array('order' => 'last_edit DESC'));

        // render
        $this->render('list', array('Decisions' => $Decisions));
    }

    /**
     * Enter description here ...
     */
    private function _delete($id)
    {
        $Decision = Decision::model()->findNonDeletedByPk($id);
        if($Decision instanceof Decision && $Decision->isOwner(User::current()->getPrimaryKey()))
        {
            if($Decision->softDelete())
            {
                Ajax::respondOk(array('deleted' => $id));
            }
        }
    }
}