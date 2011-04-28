<?php

/**
 * This is the model class for table "evaluation".
 *
 * The followings are the available columns in table 'evaluation':
 * @property string $rel_criteria_id
 * @property string $rel_alternative_id
 * @property integer $grade
 */
class Evaluation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Evaluation the static model class
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
		return 'evaluation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rel_criteria_id, rel_alternative_id, grade', 'required'),
			array('grade', 'numerical', 'integerOnly'=>true),
			array('rel_criteria_id, rel_alternative_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rel_criteria_id, rel_alternative_id, grade', 'safe', 'on'=>'search'),
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
			'rel_criteria_id' => 'Rel Criteria',
			'rel_alternative_id' => 'Rel Alternative',
			'grade' => 'Grade',
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

		$criteria->compare('rel_criteria_id',$this->rel_criteria_id,true);
		$criteria->compare('rel_alternative_id',$this->rel_alternative_id,true);
		$criteria->compare('grade',$this->grade);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}