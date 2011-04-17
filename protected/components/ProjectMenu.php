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
    public static $pages = array(
        'menu-alternatives'  => array('route' => array('alternative/create'), 'label' => 'Alternatives', 'enabled' => true),
        'menu-criteria'      => array('route' => array('criteria/create'), 'label' => 'Criteria', 'enabled' => false),
        'menu-evaluation'    => array('route' => array('evaluation/evaluate'), 'label' => 'Evaluation', 'enabled' => false),
        'menu-analysis'      => array('route' => array('analysis/display'), 'label' => 'Analysis', 'enabled' => false),
        'menu-overview'      => array('route' => array('project/details'), 'label' => 'Sharing and settings', 'enabled' => false),
    );

    /**
     * Get menu items
     */
    public static function getMenuItems()
    {
        $Project = Project::getActive();

        self::$pages['menu-criteria']['enabled']     = $Project->checkAlternativesComplete();
        self::$pages['menu-evaluation']['enabled']   = $Project->checkEvaluateConditions();
        self::$pages['menu-analysis']['enabled']     = $Project->checkEvaluationComplete();
        self::$pages['menu-overview']['enabled']     = $Project->checkAnalysisComplete();

        return self::$pages;
    }


    /**
     * Run
     */
    public function run()
    {
        $menuItems = self::getMenuItems();

        // get the last enabled tab
        $lastEnabled = null;
        foreach ($menuItems as $id => $Item)
        {
            if($Item['enabled'])
            {
                $lastEnabled = $id;
            }
            else
            {
                break;
            }
        }

        $this->render('projectMenu', array(
        	'Project' => Project::getActive(),
        	'menu' => self::getMenuItems(),
        	'currentRoute' => $this->getOwner()->getRoute(),
            'lastEnabled' => $lastEnabled,
        ));
    }
}