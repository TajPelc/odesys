<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * Default layout
     * @var string
     */
    public $layout='application.views.layouts.default';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * Costum header
     */
    public $customHeader = false;

    /**
     * Construct
     */
    public function __construct($id,$module=null)
    {
        parent::__construct($id, $module);

        /**
         * DEBUG
         */
        if(YII_DEBUG)
        {
            // simulate slow loading times
            if(0 < $sleepTime = Yii::app()->params['miliSleepTime'])
            {
                // convert mikro to mili and sleep
                usleep($sleepTime * 1000);
            }
        }
        /**
         * END DEBUG
         */
    }

    /**
     * Before action
     *
     * - refresh facebook session if needed
     *
     * @see CController::beforeAction()
     */
    function beforeAction($action) {
        // the user is logged into our page but facebook session has expired
        /*if(!Yii::app()->user->isGuest && is_null(Fb::singleton()->getSession()))
        {
            // refresh session
            $this->redirect(Fb::singleton()->getLoginStatusUrl());
        }*/

        // update last visit
        if(!Yii::app()->user->isGuest)
        {
            if((bool)$User = User::current())
            {
                $User->updateLastVisit();
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * Before render
     * - remove facebook session from $_GET
     *
     * @see CController::afterAction()
     */
    public function beforeRender($view)
    {
        // remove facebook session from url
        if($this->get('session'))
        {
            $this->redirect(strstr(Yii::app()->request->getUrl(), '?', true));
        }

        return true;
    }

    /**
     * Check if post parameter is set and return the value or false
     *
     * @param  string $key
     * @return mixed
     */
    protected function post($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : false;
    }

    /**
     * Check if post parameter is set and return the value or false
     *
     * @param  string $key
     * @return mixed
     */
    protected function get($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : false;
    }
}
