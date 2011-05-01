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
        // load decision
	    $this->getController()->Decision = Decision::model()->findByPk($this->get('decisionId'));

	    // ajax
	    if(Ajax::isAjax())
        {
            switch(true)
            {
                case isset($_POST['comment_new']):
                {
                    // create new opinion
                    $Opinion = new Opinion();
                    $Opinion->rel_user_id = Yii::app()->user->id;
                    $Opinion->rel_decision_id = $this->getController()->Decision->getPrimaryKey();
                    $Opinion->opinion = $this->post('comment_new');

                    // save
                    if(!$Opinion->save())
                    {
                        // oops, errors
                        Ajax::respondError($Opinion->getErrors());
                    }

                    // all good
                    Ajax::respondOk(array(
                    	'opinion' => '<li><img src="https://graph.facebook.com/1362051067/picture" title="" alt="" /><div><span class="author">FAKE AJAX RESPONSE says:</span><span class="timestamp">April 5th, 18:13</span><p>I am so fake, trololo. Partial needed hier.</p><span class="last">&nbsp;</span></div></li>',
                    ));
                }
            }
        }

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/public/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/score.js');

        // include CSS files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/public/index.css');


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