<?php
/**
 * Project controller
 *
 * @author Taj
 *
 */
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
            'accessControl', // perform access control
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
                'users'     => array('*'),
            ),
        );
    }

    /**
     * Project view
     */
    public function actionView()
    {
        if(isset($_GET['unsetProject']))
        {
            Project::model()->unsetActiveProject();
        }
        else
        {
            $Project = $this->loadActiveProject();
        }

        // redirect back to project index
        $this->redirect(array('project/index'));
    }

    /**
     * Create or update project
     */
    public function actionCreate()
    {
        if(isset($_GET['createNew']))
        {
            $Project = new Project();
            $Project->unsetActiveProject();
        }
        else
        {
            $Project = $this->loadActiveProject();
        }

        // save project
        if(isset($_POST['Project']))
        {
            $Project->attributes = $_POST['Project'];

            if( $Project->save() )
            {
                $this->redirect(array('criteria/create'));
            }
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/project.js');

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
        // redirect unauthenticated users
        if(Yii::app()->user->isGuest)
        {
            $this->redirect('site/index');
        }

        // add script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.color.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/project.js');

        // render index
        $this->render('index', array(
            'Project' => $this->loadActiveProject(false),
            'Projects' => Project::model()->findAllByAttributes(array('rel_user_id' => Yii::app()->user->id)),
        ));
    }

    /**
     * Set a project as active by the unique ID given
     */
    public function actionSet()
    {
        if(isset($_GET['i']))
        {
            $Project = new Project();
            $Project->unsetActiveProject();
            $Project = $Project->findByAttributes(array('url' => $_GET['i']));
            if($Project instanceof Project && $Project->rel_user_id == User::ANONYMOUS)
            {
                $Project->setAsActiveProject();
            }
        }

        $this->redirect(array('results/display'));
    }
    /**
     * Generate the project menu for ajax
     */
    public function actionMenu()
    {
        if(Ajax::isAjax())
        {
            $PM = new ProjectMenu;
            $rv['menu'] = $PM->run();
            Ajax::respondOk($rv);
        }
    }
}