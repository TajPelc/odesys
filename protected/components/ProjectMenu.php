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
        'menu-criteria'      => array('route' => array('criteria/create'), 'label' => 'Criteria', 'enabled' => true),
        'menu-alternatives'  => array('route' => array('alternative/create'), 'label' => 'Alternatives', 'enabled' => false),
        'menu-evaluation'    => array('route' => array('evaluation/evaluate'), 'label' => 'Evaluation', 'enabled' => false),
        'menu-analysis'      => array('route' => array('results/display'), 'label' => 'Graphical analysis', 'enabled' => false),
        'menu-overview'      => array('route' => array('project/details'), 'label' => 'Overview', 'enabled' => false),
    );

    /**
     * Get menu items
     */
    public static function getMenuItems()
    {
        if(false !== $Project = Project::getActive())
        {
            $evalReady = $Project->checkEvaluateConditions();
            $evalComplete = $Project->checkEvaluationComplete();
        }

        self::$pages['menu-alternatives']['enabled'] = count($Project->criteria) >= 2;
        self::$pages['menu-evaluation']['enabled']   = $evalReady;
        self::$pages['menu-analysis']['enabled']     = $evalComplete;
        self::$pages['menu-overview']['enabled']     = $evalComplete;

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