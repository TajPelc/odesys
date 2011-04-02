<?php
// import the facebook API library
Yii::import('application.vendors.facebook.src.*');
require_once('facebook.php');

/**
 * Facebook wrapper class
 *
 * @author Taj
 */
class Fb extends Facebook
{
    /**
     * Instance
     *
     * @var mixed
     */
    private static $_instance = false;

    /**
     * User identity
     */
    private $_identity;

    /**
     * The basic user data
     * @var array
     */
    public $user;

    /**
     * Initialize the FB model
     * @param array $config
     */
    public function __construct()
    {
        parent::__construct(array(
          'appId'  => Yii::app()->params['fbAppId'],
          'secret' => Yii::app()->params['fbAppSecret'],
          'cookie' => true,
        ));
    }

    /**
     * Facebook class is a singleton
     */
    public static function singleton()
    {
        $class = __CLASS__;
        if(false === self::$_instance instanceof $class)
        {
            self::$_instance = new $class;
        }

        return self::$_instance;
    }

	/**
	 * Logs in the user using FB connect.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
	    // no session found, must first hook with FB
	    if ( !$this->getSession() )
        {
            Yii::trace('Facebook login failed, no session found for unknown user.');
            return false;
        }

        try
        {
            $uid = $this->getUser();
            $User = User::model()->findByAttributes(array('facebook_id' => $uid));

            if(!empty($User))
            {
                Yii::trace('User with UID: ' . $uid . ' found!');
            }

            Yii::trace('Creating a new user for UID ' . $uid);

            $User = new User();
            $User->facebook_id = $uid;
            $User->status = User::STATUS_ACTIVE;
            $User->created = date('Y-m-d H:i:s');
            $User->lastvisit = date('Y-m-d H:i:s');
            $User->superuser = 0;

            if($User->save(false))
            {
                Yii::log('User sucessfully created. UID: ' . $uid, 'error');
            }

            Yii::log('Failed to save new FB user. UID: ' . $uid, 'error');
        }
        catch (FacebookApiException $e)
        {
            Yii::log('FB connect failed: ' . $e, 'error');
        }


	    // get identity
		if($this->_identity === null)
		{
			$this->_identity = new UserIdentity('', '');
			$this->_identity->authenticate($User);
		}
		if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
		{
			$duration = 3600*24*30; // 30 days
			Yii::app()->user->login($this->_identity, $duration);

			return true;
		}
		else
		{
			return false;
		}
	}

    /**
     * Prevent cloning of this object
     */
    public function __clone()
    {
        trigger_error('Cloning the Facebook singleton is not allowed!', E_USER_ERROR);
    }
}