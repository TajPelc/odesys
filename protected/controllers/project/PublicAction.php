<?php
/**
 * Decision public page
 *
 * @author Taj
 *
 */
class PublicAction extends Action
{
    /**
     * Action
     * @see Action::run()
     */
    public function run()
    {
        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/public/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/score.js');

        // include CSS files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/public/index.css');

        // load decision
	    $this->getController()->Decision = Decision::model()->findByPk($this->get('decisionId'));

	    // decision not found
	    if(null == $this->getController()->Decision)
	    {
    	    $this->redirect('/');
	    }

	    // load decision model
	    $this->getController()->DecisionModel = $this->getController()->Decision->getPublishedDecisionModel();

	    // analysis
	    $render = array();
	    if($this->getController()->DecisionModel instanceof DecisionModel)
	    {

            // get evaluation array
            $eval = $this->getController()->DecisionModel->getEvaluationArray();

            // find the best two alternatives by weighted score
            $bestAlternatives = $this->getController()->DecisionModel->findByWeightedScore();

            // get first and second alternative
            $firstAlternative = current($bestAlternatives);
            $secondAlternative = next($bestAlternatives);

            // render values
            $render = array(
                'eval'                     => $eval,
                'bestAlternatives'         => $bestAlternatives,
                'Alternatives'	           => $this->getController()->DecisionModel->alternatives,
                'first'                    => $firstAlternative,
                'second'                   => $secondAlternative,
                'difference'               => number_format((1 - ($secondAlternative->weightedScore / $firstAlternative->weightedScore)) * 100, 2),
            );
	    }

	    // render
        $this->render('public', $render);
    }
}