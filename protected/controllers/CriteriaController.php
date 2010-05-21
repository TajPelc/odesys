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

        // create a data provider for the defined criterias partial
        $dataProvider = new CActiveDataProvider('Criteria');
        $dataCriteria = new CDbCriteria();
        $dataCriteria->condition = 'rel_project_id=:id';
        $dataCriteria->params = array(':id' => $Project->project_id);
        $dataProvider->setCriteria($dataCriteria);

        // render the view
        $this->render('create', array(
            'dataProvider'=>$dataProvider,
            'model' => $Criteria,
            'Project' => $Project,
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
