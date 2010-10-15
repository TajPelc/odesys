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
        'Criteria' => array('criteria/create'),
        'Alternatives' => array('alternative/create'),
        'Evaluation' => array('evaluation/evaluate'),
        'Graphical analysis' => array('results/display'),
        'Overview' => array('project/details'),
    );

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

        if(Ajax::isAjax())
        {
            return $this->render('projectMenu', array('Project' => $Project, 'currentRoute' => $this->getOwner()->getRoute()), true);
        }

        $this->render('projectMenu', array('Project' => $Project, 'currentRoute' => $this->getOwner()->getRoute()));
    }
}