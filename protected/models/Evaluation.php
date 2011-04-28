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
     *  Old values
     */
    private $_oldValues;

    /**
     * Decision model
     */
    public $DecisionModel;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Evaluation
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
        return array(
            array('grade', 'required'),
            array('grade', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 100),
        );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return array(
            'Alternative' => array(self::BELONGS_TO, 'Alternative', 'rel_alternative_id'),
            'Criteria' => array(self::BELONGS_TO, 'Criteria', 'rel_criteria_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'Alternative' => array(self::BELONGS_TO, 'Alternative', 'rel_alternative_id'),
            'Criteria' => array(self::BELONGS_TO, 'Criteria', 'rel_criteria_id'),
        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
	}

    /**
     * After find
     *
     * Save old values
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->_oldValues = $this->getAttributes();
    }

    /**
     * Before save
     *
     * - update last edit
     * - disable analysis
     * - increase number of eval if new record
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            // update decision model's last edit
            $this->getDecisionModel()->updateLastEdit();

            // disable decision model step - sharing
            $this->getDecisionModel()->analysis_complete = 0;
            $this->getDecisionModel()->disableAnalysisComplete();

            if($this->isNewRecord)
            {
                // increase the number of evaluations
                $this->getDecisionModel()->increase('no_evaluation');
            }
            return true;
        }
        return false;
    }

    /**
     * Reorder criteria
     */
    public function afterDelete()
    {
        parent::afterDelete();

        // decrease the number of evaluations
        $this->getDecisionModel()->decrease('no_evaluation');
    }

    /**
     * Get decision model
     */
    public function getDecisionModel()
    {
        // check if already loaded
        if($this->DecisionModel instanceof DecisionModel)
        {
            return $this->DecisionModel;
        }

        // hack for after delete
        $id = $this->getAttribute('rel_criteria_id');
        if(!is_numeric($id))
        {
            $id = $this->_oldValues['rel_criteria_id'];
        }

        // load criteria
        $Criteria = Criteria::model()->findByPk($id);

        // load decision model
        $this->DecisionModel = $Criteria->DecisionModel;

        // return
        return $this->DecisionModel;
    }
}