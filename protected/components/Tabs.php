<?php
/**
 * Project menu widget
 *
 * @author Frenk
 *
 */
class Tabs extends CWidget
{
    /**
     * Array of link values
     *
     * @var unknown_type
     */
    public $pages = array(
        'Project details' => array('project/details'),
        'Criteria' => array('criteria/create'),
        'Alternatives' => array('alternative/create'),
        'Evaluation' => array('evaluation/evaluate'),
        'Graphical analysis' => array('results/display'),
    );
    
    
    public function run()
    {
        $this->render('tabs', array('checkUrl' => in_array(Yii::app()->controller->id . '/' . Yii::app()->controller->action->id, $this->pages) ? true : false));
    }
}