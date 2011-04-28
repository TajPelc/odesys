<?php

/**
 * This is the model class for table "opinions".
 *
 * The followings are the available columns in table 'opinions':
 * @property string $opinion_id
 * @property string $rel_user_id
 * @property string $rel_decision_id
 * @property string $opinion
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $relUser
 * @property Decision $relDecision
 */
class Opinions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Opinions the static model class
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
		return 'opinions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('opinion_id, rel_user_id, rel_decision_id, opinion, created', 'required'),
			array('opinion_id, rel_user_id, rel_decision_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('opinion_id, rel_user_id, rel_decision_id, opinion, created', 'safe', 'on'=>'search'),
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
			'relUser' => array(self::BELONGS_TO, 'User', 'rel_user_id'),
			'relDecision' => array(self::BELONGS_TO, 'Decision', 'rel_decision_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'opinion_id' => 'Opinion',
			'rel_user_id' => 'Rel User',
			'rel_decision_id' => 'Rel Decision',
			'opinion' => 'Opinion',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('opinion_id',$this->opinion_id,true);
		$criteria->compare('rel_user_id',$this->rel_user_id,true);
		$criteria->compare('rel_decision_id',$this->rel_decision_id,true);
		$criteria->compare('opinion',$this->opinion,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}