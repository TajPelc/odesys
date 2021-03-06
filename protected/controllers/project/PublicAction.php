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
        $this->getController()->Decision = Decision::model()->findNonDeletedByPk($this->get('decisionId'));

        // decision not loaded
        if(empty($this->getController()->Decision))
        {
            throw new CHttpException(404, 'Decision not found. Please use the back button to return to the previous page.');
        }

        // check privacy
        $this->_checkPrivacy();

        // custom header
        $this->getController()->customHeader = CHtml::encode(ucfirst($this->getController()->Decision->title));

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael-min-2.0.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/public/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/score.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/abacon.js');

        // include CSS files
        //Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/analysis/index.css');
        //Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/analysis/index.css');

        // load decision model
        $this->getController()->DecisionModel = $this->getController()->Decision->getLatestEvaluatedDecisionModel();

        // analysis
        $render = array();
        if($this->getController()->DecisionModel instanceof DecisionModel)
        {
            if($this->post('generateGraph'))
            {
                if ($this->post('disableWeights') === 'disable') {
                    $rv = $this->getController()->DecisionModel->getEvaluationArray(1);
                } else {
                    $rv = $this->getController()->DecisionModel->getEvaluationArray();
                }

                Ajax::respondOk(array('data' => $rv, 'disableWeights' => $this->post('disableWeights')));
            }

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
                'Alternatives'             => $this->getController()->DecisionModel->alternatives,
                'first'                    => $firstAlternative,
                'second'                   => $secondAlternative,
                'preferred'                => $this->getController()->Decision->getActiveDecisionModel()->preferred_alternative,
                'difference'               => ($firstAlternative->weightedScore > 0 ? (number_format((1 - ($secondAlternative->weightedScore / $firstAlternative->weightedScore )) * 100, 2)) : 0),
                'opinions'				   => $this->getController()->Decision->getAllOpinions(0)
            );
        }

        // render
        $this->render('public', $render);
    }

    /**
     * Redirect back
     */
    private function _redirectBack()
    {
        if(Yii::app()->user->isGuest)
        {
            $this->redirect('/');
        }
        $this->redirect('/user/dashboard');
    }

    /**
     * Check the view privacy
     */
    private function _checkPrivacy()
    {
        // may the user view this page
        $anonymous = Yii::app()->user->isGuest;
        $userMayView = false;
        $isOwner = (!$anonymous ? $this->getController()->Decision->isOwner(Common::getUser()->getPrimaryKey()) : false);

        // redirect owner to the analysis page
        if($isOwner) {
            $this->redirect(array('/decision/analysis', 'decisionId' => $this->getController()->Decision->decision_id, 'label' => $this->getController()->Decision->label));
        }

        // handle view privacy
        switch ($this->getController()->Decision->view_privacy)
        {
            // only me
            case Decision::PRIVACY_ME:
            {
                $userMayView = $isOwner;
                break;
            }
            // my friends may view
            case Decision::PRIVACY_FRIENDS:
            {
                if(!$anonymous)
                {
                    // owner or friend
                    if($isOwner || User::current()->isFriend($this->getController()->Decision->User->getPrimaryKey()))
                    {
                        $userMayView = true;
                    }
                }
                break;
            }

            // everyon may view
            case Decision::PRIVACY_EVERYONE:
            {
                $userMayView = true;
                break;
            }
        }

        if(!$userMayView)
        {
            throw new CHttpException(403, 'The decision you are trying to view has been flagged by the owner as private. If you are the owner of this decision log in to view it from your profile or use the back button to return to the previous page.');
        }
    }
}