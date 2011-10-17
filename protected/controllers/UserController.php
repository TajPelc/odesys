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

    public function init()
    {
        $this->customHeader = 'Taj Pelc\'s profile';
    }

    /**
     * List of user's notifications
     */
    public function actionNotifications()
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
                'notifications' => $this->renderPartial('notifications/list', array('notifications' => $rv['notifications']), true),
            ));
        }

        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/user/notifications.css');

        // include javascript
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/user/notifications.js');


        // render
        $this->render('notifications', array('notifications' => $rv['notifications'], 'pagination' => $rv['pagination']));
    }

    /**
     * List of user's decisions
     */
    public function actionDecisions()
    {
        // ajax
        if(Ajax::isAjax())
        {
            if($this->post('delete'))
            {
                $this->_delete($this->post('delete'));
            }
        }

        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/user/decisions.css');

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/user/decisions.js');

        // find all user's projects
        $Decisions = Decision::model()->findAllByAttributes(array('rel_user_id' => Yii::app()->user->id, 'deleted' => 0), array('order' => 'last_edit DESC'));

        // render
        $this->render('decisions', array('Decisions' => $Decisions));
    }


    /**
     * List of user's decisions
     */
    public function actionProfile()
    {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/user/profile.css');
        
        // include scripts
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/user/profile.js');
        
        // render
        $this->render('profile', array());
    }

    /**
     * Delete project helper
     */
    private function _delete($id)
    {
        $Decision = Decision::model()->findNonDeletedByPk($id);
        if($Decision instanceof Decision && $Decision->isOwner(User::current()->getPrimaryKey()))
        {
            if($Decision->softDelete())
            {
                Ajax::respondOk(array('deleted' => $id));
            }
        }
    }
}