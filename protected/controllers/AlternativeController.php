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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Add / Edit / Update alternatives
     */
    public function actionCreate()
    {
        // load active project
        $Project = $this->loadActiveProject();

        // load alternative
        $Alternative = $this->loadModel('alternative');

        // ajax
        if(Ajax::isAjax())
        {
            if($_POST['requesting'] == 'formPost')
            {
                if($this->_saveAlternative($Alternative, $Project))
                {
                    Ajax::respondOk(array('title' => $Alternative->getAttribute('title'), 'id' => $Alternative->getAttribute('alternative_id')));
                }
                else
                {
                    $rv['form'] = $this->renderPartial('_form', array('model' => $Alternative, 'Project' => $Project), true);
                    Ajax::respondError($rv);
                }
            }
            elseif($_GET['requesting'] == 'form')
            {
                $rv['form'] = $this->renderPartial('_form', array('model' => $Alternative, 'Project' => $Project), true);
                Ajax::respondOk($rv);
            }
        }

        // save alternative
        if($this->_saveAlternative($Alternative, $Project))
        {
            $this->redirect(array('alternative/create'));
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/overlay.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alternative.js');

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
            Ajax::respondOk(array('id' => $id));
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
