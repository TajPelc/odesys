<?php
/**
 * Create a new decision
 *
 * @author Taj
 *
 */
class CreateAction extends Action
{
    public function run()
    {
        // ajax only
        if(!Ajax::isAjax())
        {
            $this->redirect(array('/site/index'));
        }

        // create a new decision
        if($this->post('action') == 'create')
        {
            $Decision = new Decision();
        }

        // save project
        $Decision->title = $this->post('title');
        $Decision->rel_user_id = Yii::app()->user->id;

        // save or return errrors
        if($Decision->save())
        {
            Ajax::respondOk(array('redirectUrl' => $this->createUrl('/decision/alternatives', array('decisionId' => $Decision->decision_id, 'label' => $Decision->label))));
        }
        else
        {
            Ajax::respondError($Decision->getErrors());
        }

        Ajax::respondError(array('fail'));
    }
}