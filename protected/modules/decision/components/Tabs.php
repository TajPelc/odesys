<?php
/**
 * Decision tabs widget
 *
 * @author Taj
 *
 */
class Tabs extends CWidget
{
    /**
     * Array of link values
     *
     * @var array
     */
    public static $pages = array(
        'menu-alternatives'  => array('path' => '/decision/alternatives/', 	'route' => array('decision/alternatives/create'), 'label' => 'Alternatives', 'enabled' => true),
        'menu-criteria'      => array('path' => '/decision/criteria/', 		'route' => array('decision/criteria/create'), 'label' => 'Criteria', 'enabled' => false),
        'menu-evaluation'    => array('path' => '/decision/evaluation/', 	'route' => array('decision/evaluation/evaluate'), 'label' => 'Evaluation', 'enabled' => false),
        'menu-analysis'      => array('path' => '/decision/analysis/', 		'route' => array('decision/analysis/display'), 'label' => 'Analysis', 'enabled' => false),
        'menu-overview'      => array('path' => '/decision/sharing/', 		'route' => array('decision/sharing/index'), 'label' => 'Sharing and settings', 'enabled' => false),
    );

    /**
     * Get menu items for ajax
     */
    public static function getMenuItemsForAjax()
    {
        $Controller = new CController('DecisionController');
        $rv = array();
        foreach(self::getMenuItems() as $k => $I)
        {
            $rv[substr($k, strlen('menu-'), strlen($k))] = $I['enabled'] ? $Controller->createUrl($I['path'], array('decisionId' => Project::getActive()->project_id, 'label' => Project::getActive()->label)) : false;
        }
        return $rv;
    }

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

        $this->render('tabs', array(
          'Project' => Project::getActive(),
          'menu' => self::getMenuItems(),
          'currentRoute' => $this->getOwner()->getRoute(),
            'lastEnabled' => $lastEnabled,
        ));
    }
}
