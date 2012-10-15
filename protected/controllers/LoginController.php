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
     * Facebook login
     */
    public function actionFacebook()
    {
        // get facebook instance
        $facebook = Fb::singleton();

        // only for unauthenticated users
        if(!Yii::app()->user->isGuest)
        {
            Ajax::respondError(array('Already signed in.'));
            $this->redirect('/');
        }

        // try to get user
        $user = $facebook->getUser();

        if(Ajax::isAjax()) {
            if ($user)
            {
                $facebook->login();
                Ajax::respondOk();
            }
            Ajax::respondError(array('Could not log in.'));
        }

        // redirect to facebook
        if(!$this->get('code'))
        {
            $this->redirect($facebook->getLoginUrl(array('scope' => 'publish_stream')));
        }

        // we got the user!
        if ($user)
        {
            // login
            if($facebook->login())
            {
                if($this->get('returnTo'))
                {
                    $this->redirect($this->get('returnTo'));
                }
                $this->redirect(array('/user/notifications'));
            }
        }

        Yii::log('Facebook login failed!', 'error');
    }

    /**
     * Logout from facebook
     */
    public function actionLogout()
    {
        // guest cannot logout!
        if(Yii::app()->user->isGuest)
        {
            $this->redirect(array('site/index'));
        }

        // get user
        Yii::app()->user->logout();

        // log out
        $this->redirect(Fb::singleton()->getLogoutUrl());
    }
}
