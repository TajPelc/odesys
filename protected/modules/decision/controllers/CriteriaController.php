<?php
/**
 * Criteria controller
 *
 * @author Taj
 *
 */
class CriteriaController extends DecisionController
{
    // default action
    public $defaultAction = 'create';

    /**
     * Add / update / remove criteria.
     */
    public function actionCreate()
    {
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/criteria/index.css');

        // javascript
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery.color.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.11.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/criteria/index.js');

        // load active project
        $Project = $this->loadActiveProject();

        // ajax
        if(Ajax::isAjax())
        {
            $this->_reorderCriteria();

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
                        Ajax::respondOk(array(
                            'criteria_id' => $Criteria->criteria_id,
                            'projectMenu' => $this->getProjectMenu(),
                        ));
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
                            Ajax::respondOk(array(
                                'projectMenu' => $this->getProjectMenu(),
                            ));
                        }
                    }
                    Ajax::respondError();
                    break;
                // default action
                default:
                    Ajax::respondError();
            }
        }

        // redirect to alternatives create if not enough have been entered
        if(!$Project->checkAlternativesComplete())
        {
            $this->redirect(array('/decision/alternatives', 'decisionId' => $Project->project_id));
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
     * Reorder criteria
     */
    private function _reorderCriteria()
    {
        // params given?
        if( $this->post('criteriaOrder') )
        {
            $cArr = explode(',', $this->post('criteriaOrder'));
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
    }
}
