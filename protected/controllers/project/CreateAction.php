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
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/login/index.css');

        if(Ajax::isAjax()) {
            // create a new decision
            if($this->post('action')) {
                $Decision = new Decision();

                // save project
                $Decision->title = $this->post('title');
                $Decision->view_privacy = $this->post('privacy');
                if(Yii::app()->user->isGuest) {
                    $Decision->rel_user_id = User::ANONYMOUS;
                } else {
                    $Decision->rel_user_id = Common::getUser()->user_id;
                }

                // save or return errors
                if($Decision->validate(array('title')))
                {

                    $Decision->save(false);
                    $Decision->createActiveDecisionModel();

                    if(Yii::app()->user->isGuest) {
                        Yii::app()->session['latest_decision_process'] = $Decision->getPrimaryKey();
                    }
                    Ajax::respondOk(array('redirectUrl' => $this->createUrl('/decision/alternatives', array('decisionId' => $Decision->decision_id, 'label' => $Decision->label))));
                }
                else
                {
                    Ajax::respondError($Decision->getErrors());
                }

                Ajax::respondError(array('fail'));
            } else { // get data for the initial overlay
                Ajax::respondOk(array('html'=>$this->renderPartial('create', true, true)));
            }
        }

        $this->render('create');
    }
}