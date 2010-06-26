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

        // change the order of criteria
        if(Ajax::isAjax())
        {
            $this->_reorderCriteria();
        }

        // posted?
        if(isset($_POST['Criteria']))
        {
            // set attributes
            $Criteria->rel_project_id = $Project->project_id;
            $Criteria->attributes = $_POST['Criteria'];
            $Criteria->description =  $_POST['Criteria']['description'];
            $save = $Criteria->save();

            if($save)
            {
                $this->redirect(array('criteria/create'));
            }
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/criteria.js');

        // render the view
        $this->render('create', array(
            'model'     => $Criteria,
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

    /**
     * Reorder criteria
     */
    private function _reorderCriteria()
    {
        // params given?
        if( isset($_GET['criteriaOrder']) )
        {
            $cArr = explode(',', $_GET['criteriaOrder']);
            if(!Common::isArray($cArr))
            {
                Ajax::respondError();
            }

            // save new order of elements
            $i = 0;
            foreach($cArr as $id)
            {
                // load model and save new position
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

            Ajax::respondOk();
        }
        Ajax::respondError();
    }
}
