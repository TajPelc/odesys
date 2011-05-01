<?php
// import the facebook API library
Yii::import('application.vendors.facebook.src.*');
Yii::import('application.vendors.facebookLibrary.*');
require_once('facebook.php');
require_once('facebookLib.php');

/**
 * Facebook library wrapper that supports Yii login
 *
 * @author Taj
 */
class Fb extends facebookLib
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
     *
     * @return Fb
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

            if(empty($User))
            {
                Yii::trace('Creating a new user for UID ' . $uid);

                $User = new User();
                $User->facebook_id = $uid;
                $User->status = User::STATUS_ACTIVE;
                $User->created = date('Y-m-d H:i:s');
                $User->lastvisit = date('Y-m-d H:i:s');

                if($User->updateConfig())
                {
                    Yii::log('User sucessfully created. UID: ' . $uid, 'error');
                }

                Yii::log('Failed to save new FB user. UID: ' . $uid, 'error');
            }
            else
            {
                Yii::trace('User with UID: ' . $uid . ' found!');
            }
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
	 * Get large picture
	 *
	 * @param integer $id
	 */
	public function getLargePicture($id=null)
	{
		return $this->callApi('picture', $id, true, false, array('type' => 'large'));
	}

	/**
	 * Get users information (based on the permission you have)
	 *
	 * @param mixed $param returns a specific parameter
	 * @param string the member profile id, If null will get the current authenticated user
	 * @return array List of information about the user
	 */
	public function getInfo($id=null, $param = false)
	{
	    $arr = parent::getInfo();
		return ($param ? $arr[$param] : $arr);
	}

    /**
     * Prevent cloning of this object
     */
    public function __clone()
    {
        trigger_error('Cloning the Facebook singleton is not allowed!', E_USER_ERROR);
    }
}