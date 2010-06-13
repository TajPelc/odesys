<?php

class CriteriaController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to 'column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='column1';

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
     * Holds the criteria
     *
     * @var Criteria
     */
    protected $_Criteria;

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
     * Add / remove / edit criteria.
     */
    public function actionCreate()
    {
        // load active project
        $Project = $this->loadActiveProject();

        // load model
        $Criteria = $this->loadModel('criteria');

        // ajax request for graph data?
        if(Yii::app()->request->isAjaxRequest)
        {
            $i = 0;
            if(is_array(explode(',', $_GET['criteriaOrder'])) && count(explode(',', $_GET['criteriaOrder'])) > 1)
            {
                foreach(explode(',', $_GET['criteriaOrder']) as $id)
                {
                    $id = explode('_', $id);
                    $id = isset($id[1]) ? $id[1] : '';
                    $C = Criteria::model()->findByPk($id);
                    if(!empty($C))
                    {
                        $C->position = $i;
                        $C->save();
                    }
                    $i++;
                }
            }
            else
            {
                header('Content-type: application/json');
                echo json_encode(array('status' => false));
                exit();
            }

            header('Content-type: application/json');
            echo json_encode(array('status' => true));
            exit();
        }

        // posted?
        if(isset($_POST['Criteria']))
        {
            // set attributes
            $Criteria->rel_project_id = $Project->project_id;
            $Criteria->attributes = $_POST['Criteria'];
            $Criteria->description =  $_POST['Criteria']['description'];
            $save = $Criteria->save();

            // go to the next step
            if( $_POST['Finish'])
            {
                $this->redirect(array('alternative/create'));
            }
            elseif($save)
            {
                $this->redirect(array('criteria/create'));
            }
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.4.2.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/criteria.js');

        // position
        $criteriaCondition = new CDbCriteria();
        $criteriaCondition->condition = 'rel_project_id=:rel_project_id';
        $criteriaCondition->params = array(':rel_project_id' => $Project->project_id);
        $criteriaCondition->order = 'position ASC';

        // render the view
        $this->render('create', array(
            'model'     => $Criteria,
            'Criteria'  => Criteria::model()->findAll($criteriaCondition),
            'Project'   => $Project,
        ));
    }

    /**
     * Deletes a criteria
     */
    public function actionDelete()
    {
        $this->loadModel('criteria')->delete();
        $this->redirect(array('create'));
    }
}
