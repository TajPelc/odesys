<?php
/**
 * Evaluation controller
 *
 * @author Taj
 *
 */
class EvaluationController extends DecisionController
{
    // default action
    public $defaultAction = 'evaluate';

    /**
     * Evaluate each alternative - criteria pair
     */
    public function actionEvaluate()
    {
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/evaluation/index.css');

        // add script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluation/index.js');

        // load active project
        $Project = $this->loadActiveProject();

        // redirect to criteria create if evaluation conditions not set
        if(!$Project->checkEvaluateConditions())
        {
            if(!$Project->checkAlternativesComplete())
            {
                $this->redirect(array('/decision/alternatives', 'decisionId' => $Project->project_id, 'label' => $Project->label));
            }
            else
            {
                $this->redirect(array('/decision/criteria', 'decisionId' => $Project->project_id, 'label' => $Project->label));
            }
        }

        // ajax?
        if(Ajax::isAjax())
        {
            switch($this->post('action'))
            {
                // save empty evals
                case 'save':
                    $this->_saveEmpty();
                    Ajax::respondOk();
                // update single eval
                case 'update':
                    $this->actionUpdate();
            }
        }

        // redirect to the first unevaluated criteria
        if(false === $this->get('pageNr'))
        {
            $i = 0;
            foreach($Project->findCriteriaByPriority() as $C)
            {
                if(!$C->isDecisionEvaluated())
                {
                    // do not redirect on the first criteria
                    if($i === 0)
                    {
                        break;
                    }
                    $this->redirect(array('evaluation/evaluate', 'pageNr' => (string)$i));
                }
                $i++;
            }
        }

        // get page number
        if(false === $pageNr = $this->get('pageNr'))
        {
            $pageNr = 0;
        }

        // get criteria by position
        $Criteria = Criteria::getCriteriaByPosition($this->Decision->project_id, $pageNr);

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

        // ajax next / previous
        if(Ajax::isAjax())
        {
             if($this->post('action') == 'getContent')
             {
                $this->_saveEmpty();

                // render partial
                $html = $this->renderPartial('evaluate', array(
                    'Project'          => $Project,
                    'Criteria'         => $Criteria,
                    'eval'	           => $eval,
                    'renderEvaluation' => true,
                    'renderSidebar'	   => false,
                ), true);

                // sidebar partial
                $sidebarHtml = $this->renderPartial('evaluate', array(
                    'Project'          => $Project,
                    'Criteria'         => $Criteria,
                    'renderEvaluation' => false,
                    'renderSidebar'	   => true,
                ), true);

                // get previous and next links
                $back = false;
                $forward = false;
                if($pageNr > 0)
                {
                    $prev = $this->createUrl('evaluation/evaluate', array('pageNr' => $pageNr - 1));
                }
                else
                {
                    $prev = $this->createUrl('criteria/create');
                    $back = true;
                }
                if($pageNr < $criteriaNr - 1)
                {
                    $next = $this->createUrl('evaluation/evaluate', array('pageNr' => $pageNr + 1));
                }
                else
                {
                    $next = $this->createUrl('analysis/display');
                    $forward = true;
                }

                Ajax::respondOk(array(
                    'html' => $html,
                    'sideBar' => $sidebarHtml,
                    'title' => $Criteria->title,
                    'criteria_id' => $Criteria->criteria_id,
                    'pageNr' => $pageNr + 1,
                    'criteriaNr' => $criteriaNr,
                    'previous' => $prev,
                    'next' => $next,
                    'back' => $back,
                    'forward' => $forward,
                    'projectMenu' => $this->getProjectMenu(),
                ));
            }
        }

        // normal render
        $this->render('evaluate',array(
            'Project'          => $Project,
            'Criteria'         => $Criteria,
            'eval'	           => $eval,
            'pageNr'		   => $pageNr,
            'nrOfCriteria'	   => $criteriaNr,
            'renderEvaluation' => true,
            'renderSidebar'	   => true,
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
            if($this->_updateEvaluation($params[0], $params[1], $grade))
            {
                Ajax::respondOk(array(
                    'projectMenu' => $this->getProjectMenu(),
                ));
            }
            Ajax::respondError($Evaluation->getErrors());
        }

        Ajax::respondError();
    }

    /**
     * Save all empty evaluations
     */
    private function _saveEmpty()
    {
        $unsaved = $this->post('unsaved');
        if(!empty($unsaved))
        {
            foreach($this->post('unsaved') as $arr)
            {
                $this->_updateEvaluation($arr[0], $arr[1], 0);
            }
        }
    }

    /**
     * Update an evaluation or create a new one if it doesn't yet exist
     *
     * @param unknown_type $alternative_id
     * @param unknown_type $criteria_id
     */
    private function _updateEvaluation($alternative_id, $criteria_id, $grade)
    {
        /**
         * @TODO - privacy (check if this evaluation belongs to valid alternative & criteria
         */

        // load existing evaluation
        $Evaluation = Evaluation::model()->findByAttributes(array('rel_alternative_id' => $alternative_id, 'rel_criteria_id' => $criteria_id));

        // create new evaluation
        if(empty($Evaluation))
        {
            $Evaluation = new Evaluation();
            $Evaluation->rel_project_id = Project::getActive()->project_id;
            $Evaluation->rel_alternative_id = $alternative_id;
            $Evaluation->rel_criteria_id = $criteria_id;
        }

        $Evaluation->grade = $grade;
        if($Evaluation->save())
        {
            return true;
        }
        return false;
    }
}
