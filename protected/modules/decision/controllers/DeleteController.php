<?php
/**
 * Analysis Controller
 *
 * @author Taj
 *
 */
class DeleteController extends DecisionController
{
    // default action
    public $defaultAction = 'delete';

    /**
     * Displays a particular model.
     */
    public function actionDelete()
    {
        $decisionTitle = $this->DecisionModel->Decision->title;

        // ajax
        if(Ajax::isAjax())
        {
            // render partial
            if($this->post('partial'))
            {
                Ajax::respondOk(array('html'=>$this->renderPartial('delete', array('title' => $decisionTitle), true)));
            }

            // delete decision by id
            if($this->post('decision'))
            {
                $this->_deleteDecision($this->post('decision'));
            }
        }

        //include style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/delete.css');

        $this->render('delete', array('title' => $decisionTitle));
    }

    /**
     * Delete project helper
     */
    private function _deleteDecision($id)
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