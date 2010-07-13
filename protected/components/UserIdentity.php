<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /*
     * User id
     * @var integer
     */
    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        // load user by username
        $User = User::model()->find('username=?', array($this->username));

        // check if user has loaded
        if($User === null || $User->user_id == User::ANONYMOUS)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        // validate password
        else if(!$User->validatePassword($this->password))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        // everything ok
        else
        {
            $this->_id = $User->user_id;
            $this->setState('email', $User->email);
            $this->username = $User->username;
            $this->errorCode = self::ERROR_NONE;
        }

        // true or false
        return !$this->errorCode;
    }

    /**
     * Get id
     */
    public function getId()
    {
        return $this->_id;
    }
}