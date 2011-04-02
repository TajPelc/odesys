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
     *
     * Set default action
     * @var string
     */
    public $defaultAction = 'login';

    /**
     * Facebook action
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
}