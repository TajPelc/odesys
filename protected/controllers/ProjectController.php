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
     * Create or update project
     */
    public function actionCreate()
    {
        // ajax only
        if(!Ajax::isAjax())
        {
            $this->redirect(array('site/index'));
        }

        // create or edit
        if(false === $Project = Project::getActive())
        {
            $Project = new Project();
        }

        // what to do
        if($request = $this->post('requesting'))
        {
            switch($request)
            {
                // post the form
                case 'formPost':
                    // save project
                    if(isset($_POST['Project']))
                    {
                        $Project->attributes = $_POST['Project'];
                    }

                    // save or return errrors
                    if($Project->save())
                    {
                        Ajax::respondOk(array('project/details'));
                    }
                    else
                    {
                        $rv['form'] = $this->renderPartial('_form', array('model' => $Project), true);
                        Ajax::respondError($rv);
                    }
                    break;
                // render the form
                case 'form':
                    $rv['form'] = $this->renderPartial('_form', array('model' => $Project), true);
                    $rv['edit'] = !$Project->getIsNewRecord();
                    Ajax::respondOk($rv);
            }
        }
    }

    /**
     * Project details
     */
    public function actionDetails()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/project-details.js');

        // get project
        $Project = $this->loadActiveProject();

        // render details
        $this->render('details', array(
            'Project' => $Project,
            'Alternatives' => $Project->alternatives,
            'Criteria' => $Project->criteria,
            'eval' => $Project->getEvaluationArray(),
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
        if($_GET['unset'])
        {
            Project::unsetActiveProject();
        }

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