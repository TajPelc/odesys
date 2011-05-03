<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /*
     * User ID
     * @var integer
     */
    private $_id;

    /**
     * Is the user authenticated by facebook?
     *
     * @var unknown_type
     */
    private $_authenticatedByFacebook = false;

    /**
     * Facebook ID
     * @var string
     */
    public  $facebook_id;

    /**
     * User not active
     */
    const ERROR_STATUS_INACTIVE = 3;

    /**
     * Facebook connect failed
     */
    const ERROR_FACEBOOK_CONNECT = 4;

    /**
     * Authenticates a user.
     *
     * @return boolean whether authentication succeeds.
     */
    public function authenticate($userFromFb = false)
    {
        // login by facebook
        if($userFromFb instanceof User)
        {
            if($userFromFb === null){
                $this->errorCode = self::ERROR_FACEBOOK_CONNECT;
            }
            else if($userFromFb->status == User::STATUS_INACTIVE && Yii::app()->controller->module->loginNotActiv == false)
            {
                $this->errorCode = self::ERROR_STATUS_INACTIVE;
            }
            else
            {
                $this->_id = $userFromFb->user_id;
                $this->username = 'FB User';
                $this->setState('facebook_id',   $userFromFb->facebook_id);
                $this->setState('type', User::TYPE_FACEBOOK);
                $this->setState('data', $userFromFb->getAttributes());
                $this->errorCode = self::ERROR_NONE;
            }
        }
        else // regular login
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

    /**
     * This user is has been authenticated FB
     */
    public function setAuthenticatedByFb()
    {
        if((bool)$this->facebook_id)
        {
            $this->_authenticatedByFacebook = true;
        }
    }

    /**
     * Return the status of FB authentication
     */
    public function getAuthenticatedByFb()
    {
        return $this->_authenticatedByFacebook;
    }
}