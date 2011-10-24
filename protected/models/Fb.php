<?php
// import the facebook API library
Yii::import('application.vendors.facebook-php-sdk-668c61a.src.*');
require_once('facebook.php');

/**
 * Facebook library wrapper that supports Yii login
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
     * Initialize the FB model
     * @param array $config
     */
    public function __construct()
    {
        parent::__construct(array(
          'appId'  => Yii::app()->params['fbAppId'],
          'secret' => Yii::app()->params['fbAppSecret'],
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
        try
        {
            // no session found, must first hook with FB
            if ( 0 == $uid = $this->getUser() )
            {
                Yii::trace('Facebook login failed, no session found for unknown user.');
                return false;
            }

            // does the user exist?
            $User = User::model()->findByAttributes(array('facebook_id' => $uid));


            // not yet!
            if(empty($User))
            {
                Yii::trace('Creating a new user for UID ' . $uid);

                // get user data from facebook
                $data = Fb::singleton()->api('/me');

                // populate new user data
                $User = new User();
                $User->setAttributes(array(
                    'facebook_id' => $uid,
                    'link' => $data['link'],
                    'first_name' => (isset($data['first_name']) ? $data['first_name'] : 'John'),
                    'last_name' => (isset($data['last_name']) ? $data['last_name'] : 'Doe'),
                    'name' => (isset($data['name']) ? $data['name'] : 'John Doe'),
                    'gender' => (isset($data['gender']) ? $data['gender'] : 'male'),
                    'created' => date('Y-m-d H:i:s'),
                    'status' => User::STATUS_ACTIVE,
                    'lastvisit' => date('Y-m-d H:i:s'),
                ), false);

                // update config and save user
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
        catch (Exception $e)
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
     * Get a users friends list
     *
     * @param mixed the name or id of the object who's information we would like to retrieve
     * 				If the param is null then it will fetch the current users information
     * @return array information regarding the user friends
     */
    public function getFriends($userid=null)
    {
        return $this->callApi('friends', $userid);
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
     * Internal Call to facebook graph API
     *
     *
     * @param string the API method we would like to call
     * @param integer/string the user id or name we use to make the call
     * @param boolean if to perform a call or just return a link of that call instead
     * @param boolean if we would like to perform the call without the user id in the link
     * @param array any additional parameters to pass to the call method
     * @return mixed response
     */
    protected function callApi($api='', $userid=null, $returnLink=false, $nouid=false, $params=array())
    {
        $uid = $userid !== null ? $userid : $this->getUser();
        $uid = $nouid === true ? '' : $uid . '/';
        $apimethod = $api == 'me' ? '' : $api;
        $query = !empty($params) ? '?' . http_build_query($params) : '';
        if( $returnLink )
        {
            return Facebook::$DOMAIN_MAP['graph'] . $uid . $apimethod . $query;
        }
        return $this->api($uid . $apimethod . $query);
    }

    /**
     * Prevent cloning of this object
     */
    public function __clone()
    {
        trigger_error('Cloning the Facebook singleton is not allowed!', E_USER_ERROR);
    }
}