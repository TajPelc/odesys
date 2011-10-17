<?php

class User extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'user':
     * @var integer $user_id
     * @var string $username
     * @var string $password
     * @var string $email
     */

    const ANONYMOUS = 1;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const TYPE_FACEBOOK = 40;

    /**
     * User config
     */
    private $_config = array(
        'lang' => 'en-GB',
    );

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns the current user.
     * @return CActiveRecord the static model class
     */
    public static function current()
    {
        return self::model()->findByPk(Yii::app()->user->id);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'decisions' => array(self::HAS_MANY, 'Decision', 'rel_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'Id',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'salt' => 'Salt',
        );
    }

    /**
     * Validate password
     *
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    /**
     * Create a password hash using the password and salt
     *
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * @return string the salt
     */
    protected function generateSalt()
    {
        return uniqid('',true);
    }

    /**
     * Decrypt config
     * @see CActiveRecord::afterFind()
     */
    protected function afterFind()
    {
        $this->_config = unserialize($this->config);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * @return bool
     */
    public function getConfig($val = null)
    {
        if(is_null($val))
        {
            return $this->_config;
        }
        else
        {
            return $this->_config[$val];
        }
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * @return bool
     */
    public function setConfig($attr, $val)
    {
        $this->_config[$attr] = $val;
        $this->updateConfig();
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * @return bool
     */
    public function updateConfig()
    {
        $this->config = serialize($this->_config);

        if( $this->save(false) )
        {
            return true;
        }
        return false;
    }

    /**
     * Updates the last visit date
     *
     * @return bool
     */
    public function updateLastVisit()
    {
        $this->lastvisit = date('Y-m-d H:i:s', time());

        if( $this->save(false) )
        {
            return true;
        }
        return false;
    }

    /**
     * Retrieves and returns user's facebook friends from session
     *
     * If no data is stored in session or the data is older than 6 hours, it fetches it from facebook
     */
    public function getFriends()
    {
        // calculate the time of last fetch
        $lastUpdated = (time() - (int)Yii::app()->session['friendsUpdated']) / (60 * 60);

        // friends already loaded
        if(empty(Yii::app()->session['friends']) || $lastUpdated > 6)
        {
            return $this->fetchFriendsFromFacebook();
        }

        return Yii::app()->session['friends'];
    }

    /**
     * Retrieves users's facebook friends, saves them to session and returns them
     * also saves the time of the fetch
     */
    public function fetchFriendsFromFacebook()
    {
        $data = Fb::singleton()->getFriends($this->facebook_id);
        Yii::app()->session['friends'] = $data['data'];
        Yii::app()->session['friendsUpdated'] = time();

        return Yii::app()->session['friends'];
    }

    /**
     * Retrieves and returns user's facebook friends' ids
     */
    public function getFriendIds()
    {
        // get facebook friend's ids
        $rv = array();
        $friends = $this->getFriends();
        foreach($friends as $friend)
        {
            $rv[] = $friend['id'];
        }

        // get odesys friend's ids
        $Criteria = new CDbCriteria();
        $Criteria->addInCondition('facebook_id', $rv);

        $rv = array();
        foreach($this->findAll($Criteria) as $F)
        {
            $rv[] = $F->user_id;
        }

        return $rv;
    }

    /**
     * Check if a given user is friends with the current user
     */
    public function isFriend($userId)
    {
        foreach($this->getFriendIds() as $friendId)
        {
            if($userId == $friendId)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('username',$this->username,true);

        $criteria->compare('email',$this->email,true);

        return new CActiveDataProvider('User', array(
            'criteria'=>$criteria,
        ));
    }
}
