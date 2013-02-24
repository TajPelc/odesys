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
        return Identity::model()->findByPk(Yii::app()->user->id)->User;
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
            'decisions'     => array(self::HAS_MANY, 'Decision', 'rel_user_id'),
            'notifications' => array(self::HAS_MANY, 'Notification', 'rel_user_id'),
            'opinions'      => array(self::HAS_MANY, 'Opinion', 'rel_user_id'),
            'identities'    => array(self::HAS_MANY, 'Identity', 'rel_user_id'),
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
     * Decrypt config
     * @see CActiveRecord::afterFind()
     */
    protected function afterFind()
    {
        $this->_config = unserialize($this->config);
    }

    /**
     * Decrypt config
     * @see CActiveRecord::afterFind()
     */
    public function isAnonymous()
    {
        return (int)$this->getPrimaryKey() === self::ANONYMOUS;
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
     * Delete all user related stuff
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            // delete notifications, decision models and opinions
            foreach(array_merge($this->notifications, $this->decisions, $this->opinions, $this->identities) as $m)
            {
                $m->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * Delete this user's profile
     * @todo deauthorize user for all identities
     */
    public function deleteProfile()
    {
        try
        {
            // delete user
            if(User::current()->delete())
            {
                return true;
            }
            return false;

        }
        catch (Exception $e)
        {
            Yii::log($e->getMessage(), 'warning');
            return false;
        }
    }

    /**
     * Get the profile url
     * @return string
     */
    public function getProfileImage() {
        if($this->isAnonymous()) {
            return '/images/gravatar_default.png';
        }

        $identity = $this->identities[0];
        $pk = $identity->getPrimaryKey();
        $rv = '';
        switch($identity->service) {
            case 'facebook':
                $rv = 'https://graph.facebook.com/' . $pk . '/picture';
                break;
            case 'twitter':
                $rv = 'https://api.twitter.com/1/users/profile_image/' . $pk;
                break;
            case 'google_oauth':
                $rv = 'https://www.google.com/s2/photos/profile/' . $pk . '?sz=50';
                break;
            case 'linkedin':
            default:
                $rv = '/images/gravatar_default.png';
        }

        return $rv;
    }


    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function getGravatar( $s = 50, $d = '/images/gravatar_default.png', $r = 'g', $img = false, $atts = array() ) {
        // $i = $this->identities;
        // $email = array_pop($i)->email;
        $email = 'fakemail@reawrawerawerawr.wtf';
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
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
