<?php
/**
 * Project controller
 *
 * @author Taj
 *
 */
class ProjectController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'     => array('@'),
            ),
        );
    }

    /**
     * Create or update project
     */
    public function actionCreate()
    {
        // ajax only
        if(!Ajax::isAjax())
        {
            $this->redirect(array('site/index'));
        }

        // unset active project
        if($this->post('action') == 'create')
        {
            Project::unsetActiveProject();
            $Project = new Project();
        }
        else
        {
            $Project = Project::getActive();
        }

        // save project
        $Project->title = $this->post('title');

        // save or return errrors
        if($Project->save())
        {
            Ajax::respondOk();
        }
        else
        {
            Ajax::respondError($Project->getErrors());
        }

        Ajax::respondError(array('fail'));
    }
}