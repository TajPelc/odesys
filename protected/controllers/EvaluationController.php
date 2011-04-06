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
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/evaluation/index.css');

        // add script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluation/index.js');

        // load active project
        $Project = $this->loadActiveProject();

        // redirect to criteria create if evaluation conditions not set
        if(!$Project->checkEvaluateConditions())
        {
            if(count($Project->alternatives) < 2)
            {
                $this->redirect(array('alternative/create'));
            }
            else
            {
                $this->redirect(array('criteria/create'));
            }
        }

        // get page number
        if(false === $pageNr = $this->get('pageNr'))
        {
            $pageNr = 0;
        }

        // get criteria by position
        $Criteria = Criteria::getCriteriaByPosition($pageNr);

        // evaluation array
        $Evaluation = Evaluation::model()->findAllByAttributes(array(
        	'rel_project_id' => Project::getActive()->project_id,
            'rel_criteria_id' => $Criteria->criteria_id,
        ));

        // order by alternatives
        $eval = array();
        foreach($Evaluation as $E)
        {
            $eval[$E->rel_alternative_id] = $E;
        }

        // free mem
        $Evaluation = null; unset($Evaluation);

        // calculate the number of criteria
        $criteriaNr = count($Project->criteria);

        // ajax
        if(Ajax::isAjax())
        {
            switch($this->post('action'))
            {
                case 'getContent':

                    // render partial
                    $html = $this->renderPartial('evaluate', array(
                        'Project'          => $Project,
                        'Criteria'         => $Criteria,
                        'eval'	           => $eval,
                    ), true);

                    Ajax::respondOk(array(
                        'html' => $html,
                        'title' => $Criteria->title,
                        'pageNr' => $pageNr + 1,
                        'criteriaNr' => $criteriaNr,
                        'previous' => ($pageNr > 0 ? $this->createUrl('evaluation/evaluate', array('pageNr' => $pageNr - 1)) : false),
                        'next' => ($pageNr < $criteriaNr - 1 ? $this->createUrl('evaluation/evaluate', array('pageNr' => $pageNr + 1)) : false),
                        'projectMenu' => $this->getProjectMenu(),
                    ));
                    break;
                default:
                    Ajax::respondError();
            }
        }

        // normal render
        $this->render('evaluate',array(
            'Project'          => $Project,
            'Criteria'         => $Criteria,
            'eval'	           => $eval,
            'pageNr'		   => $pageNr,
            'nrOfCriteria'	   => $criteriaNr,
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

        // get params
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
            if($Evaluation->save())
            {
                Ajax::respondOk(array(
                    'projectMenu' => $this->getProjectMenu(),
                ));
            }
            Ajax::respondError($Evaluation->getErrors());
        }

        Ajax::respondError();
    }
}
