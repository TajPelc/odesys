<?php
/**
 * Evaluation controller
 *
 * @author Taj
 *
 */
class EvaluationController extends Controller
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
     * Evaluate each alternative - criteria pair
     */
    public function actionEvaluate()
    {
        // set sort type
        switch ($this->post('sortType'))
        {
            case 'sortByAlternatives':
                $sortType = 'alternative';
                break;
            default:
                $sortType = 'criteria';
        }

        // load active project
        $Project = $this->loadActiveProject();

        // get evaluation array
        if('criteria' == $sortType)
        {
            $eval = $Project->getEvaluationArrayByCriteria();
        }
        else
        {
            $eval = $Project->getEvaluationArray();
        }

        // evaluate!
        if(isset($_POST['eval']))
        {
            // alternatives loop
            foreach($_POST['eval'] as $alternativeId => $evals)
            {
                // criteria loop
                foreach($evals as $criteriaId => $grade)
                {
                    $Evaluation = null;

                    // get eval object by sort type
                    if('criteria' == $sortType)
                    {
                        if(isset($eval[$criteriaId]['Alternatives'][$alternativeId]['Evaluation']))
                        {
                            $Evaluation = $eval[$criteriaId]['Alternatives'][$alternativeId]['Evaluation'];
                        }
                    }
                    else
                    {
                        if(isset($eval[$alternativeId]['Criteria'][$criteriaId]['Evaluation']))
                        {
                            $Evaluation = $eval[$alternativeId]['Criteria'][$criteriaId]['Evaluation'];
                        }
                    }

                    // evaluation object is found
                    if(!empty($Evaluation))
                    {
                        $Evaluation->rel_project_id = $Project->project_id;
                        $Evaluation->rel_alternative_id = $alternativeId;
                        $Evaluation->rel_criteria_id = $criteriaId;
                        $Evaluation->grade = $grade;
                        $Evaluation->save();
                    }
                }
            }
            if(Ajax::isAjax())
            {
                Ajax::respondOk(array('redirect' => 'results/display'));
            }
            $this->redirect(array('results/display'));
        }

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluation.js');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/evaluation.css');

        // render partial for ajax
        if(Ajax::isAjax())
        {
            $rv['html'] = $this->renderPartial('evaluate', array(
                'Project'   => $Project,
                'eval'      => $eval,
                'sortType'  => $sortType,
            ), true);

            Ajax::respondOk($rv);
        }

        // normal render
        $this->render('evaluate',array(
            'Project'   => $Project,
            'eval'      => $eval,
            'sortType'  => $sortType,
        ));
    }

    /**
     * Update an individual evaluation
     */
    public function actionUpdate()
    {
        if( !Ajax::isAjax() )
        {
            return;
        }

        // get project
        $Project = Project::getActive();
        $user_id = Yii::app()->user->isGuest ? 1 : Yii::app()->user->user_id;

        // only for ajax calls
        if(!$Project && $user_id != $Project->rel_user_id)
        {
            exit();
        }

        $params = $this->post('params');
        $grade = $this->post('grade');
        $rv = array();

        // update evaluation
        if(is_array($this->post('params')) && count($this->post('params')) == 2)
        {
            // load existing evaluation
            $Evaluation = Evaluation::model()->findByAttributes(array('rel_alternative_id' => $params[0], 'rel_criteria_id' => $params[1]));

            // create new evaluation
            if(empty($Evaluation))
            {
                $Evaluation = new Evaluation();
                $Evaluation->rel_project_id = $Project->project_id;
                $Evaluation->rel_alternative_id = $params[0];
                $Evaluation->rel_criteria_id = $params[1];
            }

            $Evaluation->grade = $grade;
            $Evaluation->save();

            if($this->post('fetchMenu'))
            {
                $rv = array('menu' => ProjectMenu::getMenuItems());
            }
            Ajax::respondOk($rv);
        }
    }
}
