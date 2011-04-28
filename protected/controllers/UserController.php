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

        // load last five decisions
        $condition = new CDbCriteria();
        $condition->addCondition('rel_user_id=:user_id');
        $condition->order = 'last_edit DESC';
        $condition->limit = 3;
        $condition->params = array('user_id' => Yii::app()->user->id);
        $Decisions = Decision::model()->findAll($condition);

        $User = User::model()->findByPk(Yii::app()->user->id);

        $this->render('dashboard', array('Decisions' => $Decisions, 'User' => $User));
    }
}