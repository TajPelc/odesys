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
        // only for unauthenticated users
        if(!Yii::app()->user->isGuest)
        {
            $this->redirect('/');
        }

        // get facebook instance
        $facebook = Fb::singleton();

        // try to get user
        $user = $facebook->getUser();

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
                $this->redirect(array('/user/dashboard'));
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
