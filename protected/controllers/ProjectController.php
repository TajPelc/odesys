<?php
/**
 * Decision controller
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
     * Specify actions (non-PHPdoc)
     * @see CController::actions()
     */
    public function actions()
    {
        return array(
            'create'      => 'application.controllers.project.CreateAction',
            'list'        => 'application.controllers.project.ListAction',
            'public'      => 'application.controllers.project.PublicAction',
        );
    }
}