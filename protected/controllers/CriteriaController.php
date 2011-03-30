<?php
/**
 * Criteria controller
 *
 * @author Taj
 *
 */
class CriteriaController extends Controller
{
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
            array('allow',
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Add / remove / edit criteria.
     */
    public function actionCreate()
    {
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');

        // load active project
        $Project = $this->loadActiveProject();
        // save criteria
        if(isset($_POST['newCriteria']))
        {
            // set attributes
            $Criteria = new Criteria();
            $Criteria->attributes = $_POST['newCriteria'];

            // redirect
            if( $Criteria->save())
            {
                $this->redirect(array('criteria/create'));
            }
        }

        // javascript
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/overlay.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/criteria.js');

        // render the view
        $this->render('create', array(
            'Project'   => $Project,
        ));
    }

    /**
     * Deletes a criteria
     */
    public function actionDelete()
    {
        $Criteria = $this->loadModel('criteria');
        $id = $Criteria->criteria_id;
        if($Criteria->delete())
        {
            Ajax::respondOk(array('id' => $id, 'menu' => ProjectMenu::getMenuItems()));
        }
        else
        {
            Ajax::respondError(array('id' => $id));
        }
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
