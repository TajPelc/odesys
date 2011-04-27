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
     * Holds the active Project
     * @var Project
     */
    protected $_Project;

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
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/config.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery-1.5.1.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/index.js');
    }

    /**
     * Facebook checking before action
     *
     * @see CController::beforeAction()
     */
    function beforeAction($action) {
        // is user is logged into our page but not facebook, redirect to FB in order to refresh session
        if(!Yii::app()->user->isGuest && is_null(Fb::singleton()->getSession()))
        {
            $conact = $this->id . '/' . $this->getAction()->id;
            if(!in_array($conact, array('login/logout', 'login/facebook')))
            {
                Yii::trace('Refresh facebook session for user '. Yii::app()->user->id);
                $this->redirect($this->createUrl('/login/facebook') . '?returnTo=' . urlencode(Yii::app()->getRequest()->getRequestUri()));
            }
        }

        return parent::beforeAction($action);
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