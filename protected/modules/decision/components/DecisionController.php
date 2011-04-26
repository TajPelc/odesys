<?php
/**
 * Decision process controller
 *
 * @author Taj
 *
 */
class DecisionController extends Controller
{
    /**
     * Default layout
     * @var string
     */
    public $layout='application.modules.decision.views.layouts.projectTabs';

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
}