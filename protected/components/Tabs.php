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
     * URL's on which the project tab remains open
     *
     * @var unknown_type
     */
    public $pagesForSetProject = array(
        'project/details',
        'criteria/create',
        'alternative/create',
        'evaluation/evaluate',
        'results/display',
    );

    public function run()
    {
        $this->render('tabs', array('checkUrl' => (in_array(Yii::app()->controller->id . '/' . Yii::app()->controller->action->id, $this->pagesForSetProject)) ? true : false));
    }
}