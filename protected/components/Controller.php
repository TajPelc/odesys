<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to 'application.views.layouts.column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='application.views.layouts.column2';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

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

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.4.2.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-1.8.2.custom.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/main.js');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/ui-lightness/jquery-ui-1.8.2.custom.css');
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

    /**
     * Try to load the project from session or redirect to index page
     *
     * @return CActiveRecord
     */
    protected function loadActiveProject($redirect = true)
    {
        // get active project
        if( $project = Project::getActive() )
        {
            return $project;
        }
        else
        {
            if($redirect)
            {
                $this->redirect(array('site/index')); // redirect
            }
            else
            {
                return false;
            }
        }
    }

    /**
     * Tries to load and return a given model by it's name (given as a function parameter) and id (supplied in a $_GET parameter)
     *
     * Example:
     * Calling $this->loadModel('project').
     * $_GET['project_id'] is set to 15.
     *
     * Will return model Project with project_id 15 or thrown an exception.
     *
     * @param string $name
     * @return CActiveRecord
     */
    protected function loadModel($name)
    {
        // define names
        $modelName = ucfirst($name);
        $paramName = strtolower($name) . '_id';

        // if the model is not yet loaded
        if($this->{'_' . $modelName} === null)
        {
            // load by given id
            if(isset($_GET[$paramName]))
            {
                // try to load model
                $this->{'_' . $modelName} = call_user_func($modelName. '::model')->findbyPk($_GET[$paramName]);
            }
            else // new model
            {
                $this->{'_' . $modelName} = new $modelName();
            }

            // loading requested and failed failed
            if($this->{'_' . $modelName} === null)
            {
                // throw an exception
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }

        return $this->{'_' . $modelName};
    }
}