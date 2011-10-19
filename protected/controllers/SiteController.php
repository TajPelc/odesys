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
        
        // add meta tag
        Yii::app()->clientScript->registerMetaTag(CHtml::encode('ODESYS: Decision Support'), NULL, NULL, array('property'=>'og:title'));
        Yii::app()->clientScript->registerMetaTag(CHtml::encode('Check out this pre-release version of the new ODESYS. Please feel free to play around with the system and report any bugs that you may find. We\'ll be happy to hear your opinions, comments and suggestions. Invite your friends!'), NULL, NULL, array('property'=>'og:description'));
        Yii::app()->clientScript->registerMetaTag(CHtml::encode('http://odesys.info/images/introduction.png'), NULL, NULL, array('property'=>'og:image'));

        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
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
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/terms/index.css');
        $this->render('terms');
    }

    /**
     * Contact page
     */
    public function actionContact()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
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

        $user = false; $error = false; $fbError = false;
        if(isset($_POST['id']))
        {
            $id = ltrim($_POST['id'], '0');

            if($_POST['id'] == '00')
            {
                $id = 0;
            }

            if(!is_numeric($id))
            {
                $error = true;
                goto render;
            }

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
                $fbError = $e->getMessage();
            }

            if(!isset($testUsers[$id]))
            {
                $error = true;
                goto render;
            }

            $user = $testUsers[$id];
        }

        render:

        $this->render('eksperiment', array('error' => $error, 'user' => $user, 'fbError' => $fbError));
    }
}
