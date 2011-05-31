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
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/index/index.css');

        // include scrips
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/index/index.js');

        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
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
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * About page
     */
    public function actionAbout()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/about/index.css');
        $this->render('about');
    }

    /**
     * Terms of use page
     */
    public function actionTerms()
    {
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/terms/index.css');
        $this->render('terms');
    }

    /**
     * Contact page
     */
    public function actionContact()
    {
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/contact/index.css');
        $this->render('contact');
    }

    /**
     * Contact page
     */
    public function actionEksperiment()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/eksperiment/index.css');

        $user = false; $error = false;

        if(isset($_POST['id']))
        {
            try
            {
                Yii::import('application.vendors.facebook.src.*');
                require_once('facebook.php');

                $facebook = new Facebook(array(
                  'appId'  => '165209310185741',
                  'secret' => '8625578e976c2e457236a5cd1c0d3c79',
                ));

                //Get list of users
                $response = $facebook->api('/'.Fb::singleton()->getAppId().'/accounts/test-users');
                $testUsers = (\array_key_exists('data', $response))? $response['data']:array();
            } catch (\Exception $e) {
                dump($e);
                return;
            }

            $id = (int)ltrim($_POST['id'], '0');

            if(!isset($testUsers[$id]))
            {
                $error = true;
            }

            $user = $testUsers[$id];
        }

        $this->render('eksperiment', array('error' => $error, 'user' => $user));
    }
}