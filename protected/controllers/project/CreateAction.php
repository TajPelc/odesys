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
        // ajax
        if(Yii::app()->request->isAjaxRequest)
        {
            Ajax::respondOk(array('html'=>$this->renderPartial('create', true, true)));
        }
        else
        {
            $this->render('create');
        }

        // Create a new decision
        if(Ajax::isAjax()) {
            $Decision = new Decision();

            // save project
            $Decision->title = $this->post('title');
            $Decision->rel_user_id = User::ANONYMOUS;
            if(!Yii::app()->user->isGuest) {
                $Decision->rel_user_id = Common::getUser()->user_id;
            }

            // save or return errors
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
}