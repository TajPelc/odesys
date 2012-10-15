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

        $Decision = new Decision();

        // save project
        $Decision->title = $this->post('title');
        $Decision->rel_user_id = User::ANONYMOUS;
        if(!Yii::app()->user->isGuest) {
            $Decision->rel_user_id = Common::getUser()->user_id;
        }

        // save or return errrors
        if($Decision->validate(array('title')))
        {
            $Decision->save(false);
            $Decision->createActiveDecisionModel();

            Ajax::respondOk(array('redirectUrl' => $this->createUrl('/decision/alternatives', array('decisionId' => $Decision->decision_id, 'label' => $Decision->label))));
        }
        else
        {
            Ajax::respondError($Decision->getErrors());
        }

        Ajax::respondError(array('fail'));
    }
}