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

        if(!$this->get('session'))
        {
            // redirect to facebook
            $this->redirect(Fb::singleton()->getLoginUrl());
        }

        // login
        if( Fb::singleton()->login() )
        {
            $this->redirect(array('site/index'));
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