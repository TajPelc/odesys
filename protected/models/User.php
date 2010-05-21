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

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
			array('username, password, email', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, username, password, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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