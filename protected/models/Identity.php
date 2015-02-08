<?php

/**
 * This is the model class for table "identity".
 *
 * The followings are the available columns in table 'identity':
 * @property string $identity_id
 * @property string $name
 * @property string $service
 * @property string $rel_user_id
 *
 * The followings are the available model relations:
 * @property User $relUser
 */
class Identity extends CActiveRecord
{
    /**
     * Set primary key
     * @return string|void
     */
    public function setPrimaryKey($pk)
    {
        return 'identity_id';
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Identity the static model class
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
		return 'identity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, service, rel_user_id', 'required'),
			array('name, service', 'length', 'max'=>255),
			array('rel_user_id', 'length', 'max'=>20),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'User' => array(self::BELONGS_TO, 'User', 'rel_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'identity_id' => 'Identity',
			'name' => 'Name',
			'service' => 'Service',
			'rel_user_id' => 'Rel User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
	}
}