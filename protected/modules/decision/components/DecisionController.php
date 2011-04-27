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
     * Decision
     * @var Project
     */
    public $Decision;

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
     * Initiliaze (non-PHPdoc)
     * @see CController::init()
     */
	public function init()
	{
        // load decision
	    $this->Decision = Project::model()->findByPk($this->get('decisionId'));

	    // try to load
	    if( null === $this->Decision )
        {
            $this->redirect('/user/dashboard');
        }
	}
}