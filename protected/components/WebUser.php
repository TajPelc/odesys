<?php

/**
 * The WebUser class
 */
class WebUser extends CWebUser {
    private $_model;
    private $_identity;
    public $userId;

    /**
     * Default return url
     * @var array
     */
    public $returnUrl = array('user/profile');

    protected function beforeLogin($id, $states, $fromCookie) {
        $this->returnUrl = '/';
        return true;
    }

    protected function afterLogin($fromCookie) {
        if((bool)Yii::app()->session['latest_decision_process']) {
            $Decision = Decision::model()->findByPk(Yii::app()->session['latest_decision_process']);
            $Decision->rel_user_id = $this->getModel()->getPrimaryKey();
            $Decision->save(false);
        }
        return true;
    }

    /**
     * Return the First and Last name
     * @return string
     */
    public function getName() {
        return $this->loadUser()->getName();
    }

    /**
     * Return the first name
     * @return string
     */
    public function getFirstName() {
        $name = $this->getName();
        if(strpos($name, ' ')) {
            substr($name, 0, strpos($name, ' '));
        }
        return $name;
    }
    // This is a function that checks the field 'role'
    // in the User model to be equal to 1, that means it's admin
    // access it by Yii::app()->user->isAdmin()
    function isAdmin(){
        $user = $this->loadUser();
        return intval($user->role) == 1;
    }

    /**
     * Get the user model
     * @return mixed
     */
    public function getModel() {
        $this->loadUser();
        return $this->_model;
    }

    /**
     * Return identity
     * @return mixed
     */
    public function getIdentity() {
        $this->loadUser();
        return $this->_identity;
    }

    // Load user model.
    protected function loadUser()
    {
        if($this->_identity === null)
        {
            $this->_identity = Identity::model()->findByPk($this->id);
            if($this->_identity === null) {
                $uid = User::ANONYMOUS;
            } else {
                $uid = $this->_identity->rel_user_id;
            }
            $this->_model = User::model()->findByPk($uid);
        }
        return $this->_model;
    }
}