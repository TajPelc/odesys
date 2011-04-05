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
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/alternatives/index.css');

        // add style files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alternatives/index.js');

        // load active project
        $Project = $this->loadActiveProject();

        // ajax
        if(Ajax::isAjax())
        {
            // find alternative
            $Alternative = Alternative::model()->findByPk($this->post('alternative_id'));

            // switch
            switch ($this->post('action'))
            {
                // create/edit alternative
                case 'save':
                    if(empty($Alternative))
                    {
                        $Alternative = new Alternative();
                    }
                    // set attributes
                    $Alternative->title = $this->post('value');

                    // save
                    if($Alternative->save())
                    {
                        Ajax::respondOk(array('alternative_id' => $Alternative->alternative_id));
                    }

                    // save failed
                    Ajax::respondError($Alternative->getErrors());
                    break;
                    // delete
                case 'delete':
                    if(!empty($Alternative))
                    {
                        // delete
                        if($Alternative->delete())
                        {
                            Ajax::respondOk();
                        }
                    }
                    // delete failed
                    Ajax::respondError();
                    break;
                default:
                    Ajax::respondError();
            }
        }

        // redirect to criteria create if not enough criteria have been entered
        if(count($Project->criteria) < 2)
        {
            $this->redirect(array('criteria/create'));
        }

        // save criteria
        if(isset($_POST['newAlternative']))
        {
            // set attributes
            $Alternative = new Alternative();
            $Alternative->attributes = $_POST['newAlternative'];


            // redirect
            if( $Alternative->save())
            {
                $this->redirect(array('alternative/create'));
            }
        }

        // render the view
        $this->render('create', array(
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
}
