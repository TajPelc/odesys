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
    public $layout = 'application.modules.decision.views.layouts.projectTabs';

    /**
     * Decision
     * @var Decision
     */
    public $Decision;

    /**
     * DecisionModel
     * @var DecisionModel
     */
    public $DecisionModel;

    /**
     * Public link
     * @var string
     */
    public $publicLink;

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
     * Initiliaze (non-PHPdoc)
     * @see CController::init()
     */
    public function init()
    {
        // only authenticated users may access these pages
        if(Yii::app()->user->isGuest)
        {
            $this->redirect('/');
        }

        // load decision
        $this->Decision = Decision::model()->findNonDeletedByPk($this->get('decisionId'));

        // nothing loaded
        if(empty($this->Decision))
        {
            throw new CHttpException(404, 'Decision not found. Please use the back button to return to the previous page.');
        }

        // load decision model
        $this->DecisionModel = $this->Decision->getActiveDecisionModel();

        // if loading failed or user is not the owner => redirect to dashboard
        if( !$this->Decision->isOwner(Yii::app()->user->id) )
        {
            throw new CHttpException(403, 'You are allowed to edit this decision. Please use the back button to return to the previous page.');
        }

        // evaluate states for menu
        $this->updateStatesForMenu();

        // custom header
        $this->customHeader = CHtml::encode(ucfirst($this->Decision->title));

        // set public link
        $this->publicLink = '/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html';
    }

    /**
     * Get menu items for ajax
     */
    public function getProjectMenu()
    {
        // refresh decision model
        $this->DecisionModel->refresh();

        // update states
        $this->updateStatesForMenu();

        // build response
        $rv = array();
        foreach($this->_pages as $key => $Page)
        {
            $rv[substr($key, strlen('menu-'), strlen($key))] = $Page['enabled'] ? $this->createUrl($Page['path'], array('decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)) : false;
        }

        return $rv;
    }

    /**
     * Evaluate states for menu
     */
    public function updateStatesForMenu()
    {
        $this->_pages['menu-criteria']['enabled']     = $this->DecisionModel->checkAlternativesComplete();
        $this->_pages['menu-evaluation']['enabled']   = $this->DecisionModel->checkEvaluateConditions();
        $this->_pages['menu-analysis']['enabled']     = $this->DecisionModel->checkEvaluationComplete();
        $this->_pages['menu-overview']['enabled']     = $this->DecisionModel->checkAnalysisComplete();
    }

}
