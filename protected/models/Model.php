<?php

/**
 * This is the model class for table "model".
 *
 * The followings are the available columns in table 'model':
 * @property string $model_id
 * @property string $rel_decision_id
 * @property string $created
 * @property string $last_edit
 * @property integer $criteria_complete
 * @property integer $alternatives_complete
 * @property integer $evaluation_complete
 * @property integer $analysis_complete
 * @property integer $no_alternatives
 * @property integer $no_criteria
 * @property integer $no_evaluation
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Alternative[] $alternatives
 * @property Criteria[] $criterias
 * @property Decision $relDecision
 */
class Model extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Model the static model class
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
		return 'model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rel_decision_id, created, last_edit', 'required'),
			array('criteria_complete, alternatives_complete, evaluation_complete, analysis_complete, no_alternatives, no_criteria, no_evaluation', 'numerical', 'integerOnly'=>true),
			array('rel_decision_id', 'length', 'max'=>20),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('model_id, rel_decision_id, created, last_edit, criteria_complete, alternatives_complete, evaluation_complete, analysis_complete, no_alternatives, no_criteria, no_evaluation, description', 'safe', 'on'=>'search'),
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
			'alternatives' => array(self::HAS_MANY, 'Alternative', 'rel_model_id'),
			'criterias' => array(self::HAS_MANY, 'Criteria', 'rel_model_id'),
			'relDecision' => array(self::BELONGS_TO, 'Decision', 'rel_decision_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'model_id' => 'Model',
			'rel_decision_id' => 'Rel Decision',
			'created' => 'Created',
			'last_edit' => 'Last Edit',
			'criteria_complete' => 'Criteria Complete',
			'alternatives_complete' => 'Alternatives Complete',
			'evaluation_complete' => 'Evaluation Complete',
			'analysis_complete' => 'Analysis Complete',
			'no_alternatives' => 'No Alternatives',
			'no_criteria' => 'No Criteria',
			'no_evaluation' => 'No Evaluation',
			'description' => 'Description',
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

		$criteria->compare('model_id',$this->model_id,true);
		$criteria->compare('rel_decision_id',$this->rel_decision_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_edit',$this->last_edit,true);
		$criteria->compare('criteria_complete',$this->criteria_complete);
		$criteria->compare('alternatives_complete',$this->alternatives_complete);
		$criteria->compare('evaluation_complete',$this->evaluation_complete);
		$criteria->compare('analysis_complete',$this->analysis_complete);
		$criteria->compare('no_alternatives',$this->no_alternatives);
		$criteria->compare('no_criteria',$this->no_criteria);
		$criteria->compare('no_evaluation',$this->no_evaluation);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}