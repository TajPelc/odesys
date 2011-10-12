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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery.touch.compact.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/criteria/index.js');

        // ajax
        if(Ajax::isAjax())
        {
            $this->_reorderCriteria();

            // find criteria
            $Criteria = Criteria::model()->findByPk($this->post('criteria_id'));

            // switch
            switch ($this->post('action'))
            {
                // create / edit criteria
                case 'save':
                    // not found, create new
                    if(empty($Criteria))
                    {
                        $Criteria = new Criteria();
                    }

                    // set title
                    $Criteria->rel_model_id = $this->DecisionModel->model_id;
                    $Criteria->title = $this->post('value');

                    // save
                    if($Criteria->save())
                    {
                        Ajax::respondOk(array(
                            'criteria_id' => $Criteria->criteria_id,
                            'projectMenu' => $this->getProjectMenu(),
                        ));
                    }

                    // save failed
                    Ajax::respondError($Criteria->getErrors());

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

                // default action
                default:
                    Ajax::respondError();
            }
        }

        // redirect to alternatives create if not enough have been entered
        if(!$this->DecisionModel->checkAlternativesComplete())
        {
            $this->redirect(array('/decision/alternatives', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label));
        }

        // save criteria
        if(isset($_POST['newCriteria']))
        {
            // set attributes
            $Criteria = new Criteria();
            $Criteria->attributes = $_POST['newCriteria'];
            $Criteria->rel_model_id = $this->DecisionModel->model_id;


            // redirect
            if( $Criteria->save())
            {
                $this->redirect(array('criteria/create'));
            }
        }

        // render the view
        $this->render('create');
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
