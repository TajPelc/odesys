<?php

class AlternativeController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to 'column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='column1';

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
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('view',array(
            'model'=>$this->loadModel(),
        ));
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

        // posted?
        if(isset($_POST['Alternative']))
        {
            // set attributes
            $Alternative->rel_project_id    = $Project->project_id;
            $Alternative->attributes        = $_POST['Alternative'];
            $save = $Alternative->save();

            // go to the next step
            if( $_POST['Finish'])
            {
                $this->redirect(array('evaluation/evaluate'));
            }
            elseif($save)
            {
                $this->redirect(array('alternative/create'));
            }
        }

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
        $this->loadModel('alternative')->delete();
        $this->redirect(array('create'));
    }
}
