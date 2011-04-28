<?php

/**
 * This is the model class for table "criteria".
 *
 * The followings are the available columns in table 'criteria':
 * @property string $criteria_id
 * @property string $rel_model_id
 * @property integer $position
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Model $relModel
 * @property Alternative[] $alternatives
 */
class Criteria extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Criteria the static model class
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
		return 'criteria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rel_model_id, position, title', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('rel_model_id', 'length', 'max'=>20),
			array('title', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('criteria_id, rel_model_id, position, title', 'safe', 'on'=>'search'),
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
			'relModel' => array(self::BELONGS_TO, 'Model', 'rel_model_id'),
			'alternatives' => array(self::MANY_MANY, 'Alternative', 'evaluation(rel_criteria_id, rel_alternative_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'criteria_id' => 'Criteria',
			'rel_model_id' => 'Rel Model',
			'position' => 'Position',
			'title' => 'Title',
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

		$criteria->compare('criteria_id',$this->criteria_id,true);
		$criteria->compare('rel_model_id',$this->rel_model_id,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}