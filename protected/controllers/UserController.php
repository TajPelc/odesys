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
        // wake up notifications
        $N = new Notification();
        $pageNr = ((bool)$this->post('page') ? $this->post('page') : 0);

        // get notifications
        $rv = $N->findNotificationsForUser(User::current(), $pageNr);

        // ajax
        if(Ajax::isAjax())
        {
            Ajax::respondOk(array(
                'page' => $rv['pagination']->getCurrentPage(),
                'pageCount' => $rv['pagination']->getPageCount(),
                'notifications' => $this->renderPartial('dashboard/list', array('notifications' => $rv['notifications']), true),
            ));
        }

        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/dashboard/index.css');

        // include javascript
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dashboard/index.js');


        // render
        $this->render('dashboard', array('notifications' => $rv['notifications'], 'pagination' => $rv['pagination']));
    }
}