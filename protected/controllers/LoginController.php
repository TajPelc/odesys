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
        // logout just in case
        Yii::app()->user->logout();

        // not yet returned from facebook
        if(!$this->get('session'))
        {
            // redirect to facebook
            $this->redirect(Fb::singleton()->getLoginUrl());
        }
        // login
        if( Fb::singleton()->login() )
        {
            if($this->get('returnTo'))
            {
                $this->redirect($this->get('returnTo'));
            }
            $this->redirect(array('/user/dashboard'));
        }

        Yii::log('Facebook login failed!', 'error');
    }

    /**
     * Logout from facebook
     */
    public function actionLogout()
    {
        if(Yii::app()->user->isGuest)
        {
            $this->redirect(array('site/index'));
        }

        // get user
        $User = User::model()->findByPk(Yii::app()->user->id);
        Yii::app()->user->logout();

        $this->redirect(array('site/index'));
    }
}