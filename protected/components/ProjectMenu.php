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
    public $breadcrumbs = array();

    /**
     * Run
     */
    public function run()
    {
        // try to load Project from session
        $Project = null;
        $session = Yii::app()->session;
        if( isset($session['project_id']) )
        {
            $Project = Project::model()->findByPk($session['project_id']);
        }
        $this->render('projectMenu', array('Project' => $Project));
    }

}
