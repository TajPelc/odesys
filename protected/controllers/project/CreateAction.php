<?php
/**
 * Create project
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

        // unset active project
        if($this->post('action') == 'create')
        {
            $Project = new Project();
        }

        // save project
        $Project->title = $this->post('title');

        // save or return errrors
        if($Project->save())
        {
            Ajax::respondOk(array('redirectUrl' => $this->createUrl('/decision/alternatives', array('decisionId' => $Project->project_id, 'label' => $Project->label))));
        }
        else
        {
            Ajax::respondError($Project->getErrors());
        }

        Ajax::respondError(array('fail'));
    }
}