<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/index/index.css');

        // include scrips
        Yii::app()->clientScript->registerScriptFile('http://www.youtube.com/player_api');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/index/index.js');

        /**
         * Load 8 latest evaluated public decisions
         */
        $decisions = Decision::model()->with(array(
            'models' => array(
                'joinType' => 'INNER JOIN',
                'condition' => 'models.evaluation_complete = 1 AND t.view_privacy = 0',
                'order' => 't.created DESC'
            ),
        ))->findAll(array('limit' => 8, 'together' => true));

        $this->render('index', array('latestDecisions' => $decisions));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/error.css');
        if($error = Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                echo $error['message'];
            }
            else
            {
                $e = new stdClass();
                switch($error['code'])
                {
                    case 403:
                        $e->title = 'Access restricted!';
                        $e->message = (bool)$error['message'] ? $error['message'] : 'This page is restricted.';
                        break;
                    case 404:
                        $e->title = 'Are you lost?';
                        $e->message = 'The requested page does not exist.';
                        break;
                    default:
                        $e->title = 'Oops, we have a problem!';
                        $e->message = 'An error occured while processing your request. Please try again or return in a while.';
                        break;
                }

                $this->render('error', array('e' => $e));
            }
        }
    }

    /**
     * About page
     */
    public function actionAbout()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/about/index.css');
        $this->render('about');
    }

    /**
     * Terms of use page
     */
    public function actionTerms()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/terms/index.css');
        $this->render('terms');
    }

    /**
     * Contact page
     */
    public function actionContact()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/contact/index.css');
        $this->render('contact');
    }

}
