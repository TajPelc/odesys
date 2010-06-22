<?php

class ProjectController extends Controller
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

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
     * Project view
     */
    public function actionView()
    {
        $Project = $this->loadActiveProject();
        $this->render('view',array(
            'model' => $Project,
            'evaluation' => $Project->getEvaluationArray(),
        ));
    }

    /**
     * Create or update project
     */
    public function actionCreate()
    {
        $Project = $this->loadActiveProject();

        // save project
        if(isset($_POST['Project']))
        {
            $Project->attributes = $_POST['Project'];

            if( $Project->save() )
            {
                $this->redirect(array('criteria/create'));
            }
        }

        // render
        $this->render('create',array(
            'model' => $Project,
        ));
    }

    /**
     * Deletes a particular model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadActiveProject()->delete();
            $this->redirect(array('index'));
        }
        else
        {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all user's projects.
     */
    public function actionIndex()
    {
        // render index
        $this->render('index', array(
            'Projects' => Project::model()->findAllByAttributes(array('rel_user_id' => Yii::app()->user->id)),
        ));
    }
}