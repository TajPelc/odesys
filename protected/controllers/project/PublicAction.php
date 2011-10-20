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

        // ajax
        if(Ajax::isAjax())
        {
            switch(true)
            {
                // new comment
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
                        'opinion' => $this->renderPartial('_opinion', array('models' => array($Opinion)), true),
                    ));
                }
                // get more comments
                case isset($_POST['showMore']):
                {
                    $pageNr = $this->post('opinionPage') ? $this->post('opinionPage') : 0;
                    $rv = $this->getController()->Decision->getAllOpinions($pageNr);

                    Ajax::respondOk(array(
                        'more' => $this->renderPartial('_opinion', array('models' => $rv['models']), true),
                        'pageCount' => $rv['pagination']->getPageCount(),
                    ));
                }
            }
        }

        //include script files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/public/index.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/raphael-min-2.0.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/score.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/analysis/abacon.js');

        // include CSS files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/public/index.css');
        //Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/analysis/index.css');

        // add meta tag
        Yii::app()->clientScript->registerMetaTag(CHtml::encode($this->getController()->Decision->title), NULL, NULL, array('property'=>'og:title'));
        Yii::app()->clientScript->registerMetaTag(CHtml::encode($this->getController()->Decision->description), NULL, NULL, array('property'=>'og:description'));
        Yii::app()->clientScript->registerMetaTag(CHtml::encode(Common::getBaseURL().'/images/introduction.png'), NULL, NULL, array('property'=>'og:image'));

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
                'Alternatives'             => $this->getController()->DecisionModel->alternatives,
                'first'                    => $firstAlternative,
                'second'                   => $secondAlternative,
                'difference'               => ($firstAlternative->weightedScore > 0 ? (number_format((1 - ($secondAlternative->weightedScore / $firstAlternative->weightedScore )) * 100, 2)) : 0),
                'enableComments'           => !Yii::app()->user->isGuest,
                'opinions'				   => $this->getController()->Decision->getAllOpinions(0),
            );
        }
        else if( $this->getController()->Decision->isOwner(User::current()->getPrimaryKey())) // not yet published and viewed by owner
        {
            // redirect back to publish page
            $this->redirect(array('/decision/sharing', 'decisionId' => $this->getController()->Decision->decision_id, 'label' => $this->getController()->Decision->label));
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
        $isOwner = (!$anonymous ? $this->getController()->Decision->isOwner(Yii::app()->user->id) : false);

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
            throw new CHttpException(403, 'The decision you are trying to view is private. Use the back button to return to the previous page.');
        }
    }
}