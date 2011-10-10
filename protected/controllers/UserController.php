<?php
/**
 *
 * User controller
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
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/dashboard/index.css');

        // include javascript
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dashboard/index.js');

        // get notifications
        $N = new Notification();

        // render
        $this->render('dashboard', array('Notifications' => $N->findNotificationsForUser(User::current())));
    }
}