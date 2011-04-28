<?php

/**
 * This is the model class for table "decision".
 *
 * The followings are the available columns in table 'decision':
 * @property string $decision_id
 * @property string $rel_user_id
 * @property string $title
 * @property string $label
 * @property string $created
 * @property string $last_edit
 * @property string $description
 *
 * The followings are the available model relations:
 * @property User $relUser
 * @property Model[] $models
 * @property Opinions[] $opinions
 */
class Decision extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Decision the static model class
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
		return 'decision';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rel_user_id, title, label, created, last_edit', 'required'),
			array('rel_user_id', 'length', 'max'=>20),
			array('title, label', 'length', 'max'=>45),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('decision_id, rel_user_id, title, label, created, last_edit, description', 'safe', 'on'=>'search'),
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
			'models' => array(self::HAS_MANY, 'Model', 'rel_decision_id'),
			'opinions' => array(self::HAS_MANY, 'Opinions', 'rel_decision_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'decision_id' => 'Decision',
			'rel_user_id' => 'Rel User',
			'title' => 'Title',
			'label' => 'Label',
			'created' => 'Created',
			'last_edit' => 'Last Edit',
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

		$criteria->compare('decision_id',$this->decision_id,true);
		$criteria->compare('rel_user_id',$this->rel_user_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_edit',$this->last_edit,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}