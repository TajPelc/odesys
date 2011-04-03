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
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/criteria/index.css');

        // javascript
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/criteria/index.js');

        // load active project
        $Project = $this->loadActiveProject();

        // ajax
        if(Ajax::isAjax())
        {
            // find criteria
            $Criteria = Criteria::model()->findByPk($this->post('criteria_id'));

            // switch
            switch ($this->post('action'))
            {
                // create/edit criteria
                case 'save':
                    // not yet loaded, create new
                    if(empty($Criteria))
                    {
                        $Criteria = new Criteria();
                    }

                    // set title
                    $Criteria->title = $this->post('value');

                    // save
                    if($Criteria->save())
                    {
                        // all good, reutrn new criteria id
                        Ajax::respondOk(array('criteria_id' => $Criteria->criteria_id));
                    }

                    // save failed
                    Ajax::respondError($Criteria->getErrors());
                    break;
                // delete
                case 'delete':
                    // criteria found!
                    if(!empty($Criteria))
                    {
                        // delete
                        if($Criteria->delete())
                        {
                            Ajax::respondOk();
                        }
                    }
                    Ajax::respondError();
                    break;
                // default action
                default:
                    Ajax::respondError();
            }
        }

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
