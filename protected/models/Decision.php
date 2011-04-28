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
	 * @return Decision
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
		return array(
            array('title', 'filter', 'filter' => 'trim'),
            array('title', 'required'),
            array('title', 'length', 'max' => 45),
			array('title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'User' => array(self::BELONGS_TO, 'User', 'rel_user_id'),
			'models' => array(self::HAS_MANY, 'DecisionModel', 'rel_decision_id'),
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
		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Handle all the logic before saving
     *
     * - set created time and label for new records
     * - update last edit time
     */
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            // new record
            if( $this->isNewRecord )
            {
                $this->created = date('Y-m-d H:i:s', time());
                $this->label = Common::toAscii($this->title, array('’', '\''));
                $this->label = strlen($this->label) > 0 ? $this->label : 'my-decision';
            }
            $this->updateLastEdit(false);
            return true;
        }
        return false;
    }

    /**
     * Delete all decision related stuff
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            // delete decision models and opinions
            foreach(array_merge($this->models, $this->opinions) as $m)
            {
                $m->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * Update last edit time
     * @param bool $save
     */
    public function updateLastEdit($save = true)
    {
        $this->last_edit = date('Y-m-d H:i:s');

        if($save)
        {
            $this->save();
        }
    }

    /**
     * Get active decision model
     */
    public function getActiveDecisionModel()
    {
        return DecisionModel::model()->findByAttributes(array('rel_decision_id' => $this->decision_id, 'status' => DecisionModel::ACTIVE));
    }

    /**
     * Create active decision model
     */
    public function createActiveDecisionModel()
    {
        // no active decision model yet
        if(count($this->models) == 0)
        {
            // create a new decision model
            $DecisionModel = new DecisionModel();
            $DecisionModel->rel_decision_id = $this->decision_id;
            $DecisionModel->status = DecisionModel::ACTIVE;
            $DecisionModel->save();
        }
    }
}