<?php
/**
 * Analysis Controller
 *
 * @author Taj
 *
 */
class AnalysisController extends DecisionController
{
    // default action
    public $defaultAction = 'display';

    /**
     * Displays a particular model.
     */
    public function actionDisplay()
    {
        // redirect to evaluation if it's not yet complete
        if(!$this->DecisionModel->checkEvaluationComplete())
        {
            $this->redirect(array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label));
        }

        if(Ajax::isAjax())
        {
            // favourite alternative
            if($this->post('favourite') && $this->post('alternative')) {
                $model = $this->Decision->getActiveDecisionModel();
                $model->preferred_alternative = $this->post('alternative');
                $model->save();
                Ajax::respondOk();
            }

            // save description
            if($this->post('description'))
            {
                // set value
                $this->Decision->description = $this->post('description');

                // validate post
                $this->Decision->save(false);
            }

            if($this->post('generateGraph'))
            {
                if ($this->post('disableWeights') === 'disable') {
                    $rv = $this->DecisionModel->getEvaluationArray(1);
                } else {
                    $rv = $this->DecisionModel->getEvaluationArray();
                }

                Ajax::respondOk(array('data' => $rv, 'disableWeights' => $this->post('disableWeights')));
            }

            Ajax::respondOk(array('html'=>$this->renderPartial('display', array('description' => CHtml::encode($this->Decision->description)), true)));
        }

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery.selectBox.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael-min-2.0.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/score.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/abacon.js');

        //include style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/analysis/index.css');

        // get evaluation array
        $eval = $this->DecisionModel->getEvaluationArray();

        // find the best two alternatives by weighted score
        $bestAlternatives = $this->DecisionModel->findByWeightedScore();

        // get first and second alternative
        $firstAlternative = current($bestAlternatives);
        $secondAlternative = next($bestAlternatives);

        // check for specific decision names
        $decisionTitleNotice = false;
        if(preg_match_all('/\b(kill myself|kill me|suicide|i die|be or not to be|end my existence|end my miserable existence)\b/i', CHtml::encode($this->Decision->title), $matches)){
            $decisionTitleNotice = true;
        }

        $this->render('display', array(
            'description'              => CHtml::encode($this->Decision->description),
            'decisionTitleNotice'      => $decisionTitleNotice,
            'eval'                     => $eval,
            'bestAlternatives'         => $bestAlternatives,
            'Alternatives'	           => $this->DecisionModel->alternatives,
            'first'                    => $firstAlternative,
            'second'                   => $secondAlternative,
            'preferred'                => $this->Decision->getActiveDecisionModel()->preferred_alternative,
            'difference'               => ($firstAlternative->weightedScore > 0 ? (number_format((1 - ($secondAlternative->weightedScore / $firstAlternative->weightedScore )) * 100, 2)) : 0),
        ));
    }
}