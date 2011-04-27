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
     * Array of link values
     *
     * @var array
     */
    protected $_pages = array(
        'menu-alternatives'  => array('path' => '/decision/alternatives/', 	'route' => array('decision/alternatives/create'), 'label' => 'Alternatives', 'enabled' => true),
        'menu-criteria'      => array('path' => '/decision/criteria/', 		'route' => array('decision/criteria/create'), 'label' => 'Criteria', 'enabled' => false),
        'menu-evaluation'    => array('path' => '/decision/evaluation/', 	'route' => array('decision/evaluation/evaluate'), 'label' => 'Evaluation', 'enabled' => false),
        'menu-analysis'      => array('path' => '/decision/analysis/', 		'route' => array('decision/analysis/display'), 'label' => 'Analysis', 'enabled' => false),
        'menu-overview'      => array('path' => '/decision/sharing/', 		'route' => array('decision/sharing/index'), 'label' => 'Sharing and settings', 'enabled' => false),
    );

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

        // evaluate states for menu
        $this->updateStatesForMenu();
	}

    /**
     * Get menu items for ajax
     */
    public function getProjectMenu()
    {
        // refresh decision model
        $this->Decision->refresh();

        // update states
        $this->updateStatesForMenu();

        // build response
        $rv = array();
        foreach($this->_pages as $key => $Page)
        {
            $rv[substr($key, strlen('menu-'), strlen($key))] = $Page['enabled'] ? $this->createUrl($Page['path'], array('decisionId' => $this->Decision->project_id, 'label' => $this->Decision->label)) : false;
        }

        return $rv;
    }

    /**
     * Evaluate states for menu
     */
    public function updateStatesForMenu()
    {
        $this->_pages['menu-criteria']['enabled']     = $this->Decision->checkAlternativesComplete();
        $this->_pages['menu-evaluation']['enabled']   = $this->Decision->checkEvaluateConditions();
        $this->_pages['menu-analysis']['enabled']     = $this->Decision->checkEvaluationComplete();
        $this->_pages['menu-overview']['enabled']     = $this->Decision->checkAnalysisComplete();
    }

}