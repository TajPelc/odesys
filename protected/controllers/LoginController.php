<?php
/**
 *
 * Facebook login controller
 * @author Taj
 *
 */
class LoginController extends Controller
{
    /**
     * Login
     */
    public function actionIndex() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/login/index.css');

        /**
         * Render overlay
         */
        if(Yii::app()->request->isAjaxRequest)
        {
            Ajax::respondOk(array('html'=>$this->renderPartial('index', array('connectToAccount' => ((bool)$this->post('isGuest') && (bool)Yii::app()->session['latest_decision_process'])), true)));
        }

        /**
         * Login with a service
         * @TODO move parts of this to the WebUser model
         */
        $service = Yii::app()->request->getQuery('service');
        if (isset($service)) {
            $wasGuest = Yii::app()->user->isGuest;
            $formerId = Yii::app()->user->id;

            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('login');

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
                        } else { // add additional identities
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
            $this->render('index');
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
}
