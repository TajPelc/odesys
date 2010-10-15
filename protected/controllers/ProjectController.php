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
        // create   
        if(false === $Project = Project::getActive())
        {
            $Project = new Project();
        }
        // ajax
        if(Ajax::isAjax())
        {
            if(isset($_POST['requesting']) && $_POST['requesting'] == 'formPost')
            {
                // save project
                if(isset($_POST['Project']))
                {
                    $Project->attributes = $_POST['Project'];
                }
                
                // save or return errrors
                if($Project->save())
                {
                    Ajax::respondOk(array('this is redirect url'));
                }
                else
                {
                    $rv['form'] = $this->renderPartial('_form', array('model' => $Project), true);
                    Ajax::respondError($rv);
                }
            }
            elseif(isset($_POST['requesting']) && $_POST['requesting'] == 'form')
            {
                $rv['form'] = $this->renderPartial('_form', array('model' => $Project), true);
                $rv['edit'] = !$Project->getIsNewRecord();
                Ajax::respondOk($rv);
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
            $this->redirect(array('site/index'));
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
            if($Project instanceof Project /*&& $Project->rel_user_id == User::ANONYMOUS*/) // @TODO SET PUBLIC/PRIVATE FLAG
            {
                $Project->setAsActiveProject();
                $this->redirect(array('project/create'));
            }
        }
        $this->redirect(array('site/index'));
    }
    /**
     * Generate the project menu for ajax
     */
    public function actionMenu()
    {
        if(Ajax::isAjax())
        {
            $this->loadActiveProject();
            $PM = new ProjectMenu;
            $rv['menu'] = $PM->run();
            Ajax::respondOk($rv);
        }
    }
}