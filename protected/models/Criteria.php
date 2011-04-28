<?php

/**
 * This is the model class for table "criteria".
 *
 * Extends DecisionElement
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
class Criteria extends DecisionElement
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Criteria
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
        return array(
            array('title', 'filter', 'filter' => 'trim'),
            array('title', 'required'),
            array('title', 'length', 'max' => 60),
            array('title', 'isDecisionModelUnique'),
			array('title', 'safe', 'on'=>'search'),
        );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'DecisionModel' => array(self::BELONGS_TO, 'DecisionModel', 'rel_model_id'),
            'evaluations' => array(self::HAS_MANY, 'Evaluation', 'rel_criteria_id'),
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
		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Before save
     *
     * Update decision model last edit
     * Set position
     * Increase decision model criteria counter
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            if(!$this->clone)
            {
                // update decision model's last edit
                $this->DecisionModel->updateLastEdit();

                if($this->isNewRecord)
                {
                    // set initial position
                    $this->position = $this->DecisionModel->no_criteria;

                    // increase the number of criteria
                    $this->DecisionModel->increase('no_criteria');
                }
            }
            return true;
        }
        return false;
    }

    /**
     * After delete
     *
     * - Reorder criteria
     */
    public function afterDelete()
    {
        parent::afterDelete();

        // create query criteria
        $dbCriteria= new CDbCriteria();
        $dbCriteria->condition = 'rel_model_id = :rel_model_id';
        $dbCriteria->order = 'position ASC';
        $dbCriteria->params = array(':rel_model_id' => $this->_oldValues['rel_model_id']);

        // query
        $result = self::model()->findAll($dbCriteria);

        // reorder and save
        for($i = 0; $i < count($result); $i++)
        {
            $result[$i]->position = $i;
            $result[$i]->save();
        }

        // decrease the number of criteria
        DecisionModel::model()->findByPk($this->_oldValues['rel_model_id'])->decrease('no_criteria');
    }

    /**
     * Return criteria for the current decision model matching the position given
     *
     * @param int $position
     */
    public static function getCriteriaByPosition($id, $position)
    {
        return self::model()->findByAttributes(array('rel_model_id' => $id, 'position' => $position));
    }

    /**
     * Check if this decision is evaluated by current criteria
     *
     * @param int $position
     */
    public function isDecisionEvaluated()
    {
        // if there are the same number of evaluations with this criteria and decision model id as there are alternatives, then this criteria has been evaluated
        return ($this->DecisionModel->no_alternatives == Evaluation::model()->countByAttributes(array('rel_criteria_id' => $this->criteria_id)));
    }
}