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
     * Login
     */
    public function actionLogin() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/login/index.css');

        /**
         * Render overlay
         */
        if(Yii::app()->request->isAjaxRequest)
        {
            Ajax::respondOk(array('html'=>$this->renderPartial('login', true, true)));
        }

        /**
         * Login with a service
         */
        $service = Yii::app()->request->getQuery('service');
        if (isset($service)) {
            $wasGuest = Yii::app()->user->isGuest;
            $formerId = Yii::app()->user->id;
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('site/login');

            if ($authIdentity->authenticate()) {
                $identity = new EAuthUserIdentity($authIdentity);
                // successful authentication
                if ($identity->authenticate()) {
                    Yii::app()->user->login($identity);

                    $savedIdentity = Identity::model()->findByPk(Yii::app()->user->id);
                    if(null === $savedIdentity) {
                        // create a new user
                        if($wasGuest) {
                            $User = new User();
                            $User->save();
                        } else { // add aditional identities
                            $User = Common::getUser($formerId);
                        }
                        if(!$User->isAnonymous()){
                            $savedIdentity = new Identity();
                            $savedIdentity->identity_id = Yii::app()->user->id;
                            $savedIdentity->rel_user_id = $User->getPrimaryKey();
                            $savedIdentity->name = Yii::app()->user->name;
                            $savedIdentity->service = Yii::app()->user->service;
                            $savedIdentity->save();
                        }
                    }

                    // special redirect with closing popup window
                    $authIdentity->redirect();
                }
                else {
                    // close popup window and redirect to cancelUrl
                    $authIdentity->cancel();
                }
            }

            // Something went wrong, redirect to login page
            $this->redirect(array('site/index'));
        } else {
            $this->render('login');
        }
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
