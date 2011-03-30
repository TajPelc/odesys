<?php
/**
 * Alternative controller
 *
 * @author Taj
 *
 */
class AlternativeController extends Controller
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    protected $_Alternative;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Add / Edit / Update alternatives
     */
    public function actionCreate()
    {
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');

        // load active project
        $Project = $this->loadActiveProject();

        // load alternative
        $Alternative = $this->loadModel('alternative');

        // ajax
        if(Ajax::isAjax())
        {
            if($this->post('requesting') == 'formPost')
            {
                if($this->_saveAlternative($Alternative, $Project))
                {
                    Ajax::respondOk(array('title' => $Alternative->getAttribute('title'), 'id' => $Alternative->getAttribute('alternative_id'), 'menu' => ProjectMenu::getMenuItems()));
                }
                else
                {
                    $rv['form'] = $this->renderPartial('_form', array('model' => $Alternative, 'Project' => $Project), true);
                    Ajax::respondError($rv);
                }
            }
            elseif($this->get('requesting') == 'form')
            {
                $rv['form'] = $this->renderPartial('_form', array('model' => $Alternative, 'Project' => $Project), true);
                Ajax::respondOk($rv);
            }
        }

        // redirect to criteria create if not enough criteria have been entered
        if(count($Project->criteria) < 2)
        {
            $this->redirect(array('criteria/create'));
        }

        // save alternative
        if($this->_saveAlternative($Alternative, $Project))
        {
            $this->redirect(array('alternative/create'));
        }

        // render the view
        $this->render('create', array(
            'model'         => $Alternative,
            'Project'       => $Project,
        ));
    }

    /**
     * Deletes an alternative
     */
    public function actionDelete()
    {
        $Alternative = $this->loadModel('Alternative');
        $id = $Alternative->alternative_id;
        if($Alternative->delete())
        {
            Ajax::respondOk(array('id' => $id, 'menu' => ProjectMenu::getMenuItems()));
        }
        else
        {
            Ajax::respondError(array('id' => $id));
        }
        $this->redirect(array('create'));
    }

    /**
     * Save alternative
     *
     * @var Alternative Alternative
     * @var Project $Project
     */
    private function _saveAlternative($Alternative, $Project)
    {
        // only allow up to 10 alternatives
        if($Alternative->getIsNewRecord() && count($Project->alternatives) >= 10)
        {
            return false;
        }
        if(isset($_POST['Alternative']))
        {
            // set attributes
            $Alternative->rel_project_id    = $Project->project_id;
            $Alternative->title             = $_POST['Alternative']['title'];
            $Alternative->description       =  $_POST['Alternative']['description'];
            return $Alternative->save();
        }
    }
}
