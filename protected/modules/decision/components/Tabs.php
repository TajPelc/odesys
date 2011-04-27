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
     * Holds the decision
     */
    public $Decision;

    /**
     * Holds the array of link values
     */
    public $pages;

    /**
     * Run
     */
    public function run()
    {
        // get the last enabled tab
        $lastEnabled = null;
        foreach ($this->pages as $id => $Item)
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

        // render
        $this->render('tabs', array(
            'currentRoute' => $this->getOwner()->getRoute(),
			'lastEnabled' => $lastEnabled,
        ));
    }
}
