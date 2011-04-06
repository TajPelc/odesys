<?php
/**
 *
 * Facebook login controller
 * @author Taj
 *
 */
class UserController extends Controller
{
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
            ),
        );
    }

    /**
     * Facebook login
     */
    public function actionDashboard()
    {
        $this->render('dashboard');
    }
}