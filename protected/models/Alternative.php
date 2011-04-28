<?php

/**
 * This is the model class for table "alternative".
 *
 * The followings are the available columns in table 'alternative':
 * @property string $alternative_id
 * @property string $rel_model_id
 * @property string $title
 * @property double $score
 * @property double $weightedScore
 * @property string $color
 *
 * The followings are the available model relations:
 * @property Model $relModel
 * @property Criteria[] $criterias
 */
class Alternative extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Alternative the static model class
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
		return 'alternative';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rel_model_id, title, color', 'required'),
			array('score, weightedScore', 'numerical'),
			array('rel_model_id', 'length', 'max'=>20),
			array('title', 'length', 'max'=>60),
			array('color', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('alternative_id, rel_model_id, title, score, weightedScore, color', 'safe', 'on'=>'search'),
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
			'criterias' => array(self::MANY_MANY, 'Criteria', 'evaluation(rel_alternative_id, rel_criteria_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alternative_id' => 'Alternative',
			'rel_model_id' => 'Rel Model',
			'title' => 'Title',
			'score' => 'Score',
			'weightedScore' => 'Weighted Score',
			'color' => 'Color',
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

		$criteria->compare('alternative_id',$this->alternative_id,true);
		$criteria->compare('rel_model_id',$this->rel_model_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('weightedScore',$this->weightedScore);
		$criteria->compare('color',$this->color,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}