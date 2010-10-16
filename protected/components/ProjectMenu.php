<?php
/**
 * Project menu widget
 *
 * @author Taj
 *
 */
class ProjectMenu extends CWidget
{
    /**
     * Array of link values
     *
     * @var unknown_type
     */
    public $pages = array(
        'menu-criteria'      => array('route' => array('criteria/create'), 'label' => 'Criteria', 'enabled' => true),
        'menu-alternatives'  => array('route' => array('alternative/create'), 'label' => 'Alternatives', 'enabled' => true),
        'menu-evaluation'    => array('route' => array('evaluation/evaluate'), 'label' => 'Evaluation', 'enabled' => true),
        'menu-analysis'      => array('route' => array('results/display'), 'label' => 'Graphical analysis', 'enabled' => true),
        'menu-overview'      => array('route' => array('project/details'), 'label' => 'Overview', 'enabled' => true),
    );

    /**
     * Run
     */
    public function run()
    {
        $Project = Project::getActive();

        /* @TODO
        $evalReady = $Project->checkEvaluateConditions();
        $evalComplete = $Project->checkEvaluationComplete();

        $this->pages['menu-evaluation']['enabled']   = $evalReady;
        $this->pages['menu-analysis']['enabled']     = $evalComplete;
        $this->pages['menu-overview']['enabled']     = $evalComplete;
        */

        if(Ajax::isAjax())
        {
            return $this->render('projectMenu', array('Project' => $Project, 'currentRoute' => $this->getOwner()->getRoute()), true);
        }

        $this->render('projectMenu', array('Project' => $Project, 'currentRoute' => $this->getOwner()->getRoute()));
    }
}