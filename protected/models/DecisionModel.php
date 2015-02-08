<?php

/**
 * This is the model class for table "model".
 *
 * The followings are the available columns in table 'model':
 * @property string $model_id
 * @property string $rel_decision_id
 * @property integer $status
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
 * @property integer $preferred_alternative
 *
 * The followings are the available model relations:
 * @property Alternative[] $alternatives
 * @property Criteria[] $criterias
 * @property Decision $relDecision
 */
class DecisionModel extends CActiveRecord
{
    /**
     * Active decision model (beeing modified)
     * @var integer
     */
    const ACTIVE = 0;

    /**
     * Published decision model
     * @var integer
     */
    const PUBLISHED = 1;

    /**
     * Archived decision model
     * @var integer
     */
    const ARCHIVED = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @return DecisionModel
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
		return 'decision_model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'alternatives' => array(self::HAS_MANY, 'Alternative', 'rel_model_id'),
			'criteria' => array(self::HAS_MANY, 'Criteria', 'rel_model_id'),
			'Decision' => array(self::BELONGS_TO, 'Decision', 'rel_decision_id'),
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
		$criteria=new CDbCriteria;
		$criteria->compare('description',$this->description,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/**
     * Handle all the logic before saving
     */
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            // new record
            if( $this->isNewRecord )
            {
                $this->created = date('Y-m-d H:i:s', time());
            }
            $this->updateLastEdit(false);
            return true;
        }
        return false;
    }

    /**
     * Delete all decision model related stuff
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            // delete criteria and alternatives
            foreach(array_merge($this->criteria, $this->alternatives) as $m)
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
     * Increase the value of a count field by one
	 *
     * @param int $field
     */
    public function increase($field)
    {
        $this->{$field} = $this->{$field} + 1;
        $this->save();

        $this->evaluateConditions();
    }

    /**
     * Decrease the value of a count field by one
	 *
     * @param int $field
     */
    public function decrease($field)
    {
        $this->{$field} = $this->{$field} - 1;
        $this->save();

        $this->evaluateConditions();
    }

    /**
     * Evaluate the conditions for the different steps of the decision model
     */
    public function evaluateConditions()
    {
        // check criteria conditions
        $criteriaComplete         = (int)($this->no_criteria >= 2);

        // check alternative conditions
        $alternativesComplete     = (int)($this->no_alternatives >= 2);

        // check evaluation condition
        $nrOfExpectedEvaluations  = (int)$this->no_criteria * (int)$this->no_alternatives;
        $evaluationComplete       = 0;
        if((bool)$criteriaComplete
            && (bool)$alternativesComplete
            && $nrOfExpectedEvaluations > 0
            && ((int)$this->no_evaluation == $nrOfExpectedEvaluations)
        )
        {
            $evaluationComplete = 1;
        }

        // values changed, update
        if($criteriaComplete !== (int)$this->criteria_complete
            || $alternativesComplete !== (int)$this->alternatives_complete
            || $evaluationComplete !== (int)$this->evaluation_complete
        )
        {
            $this->criteria_complete = $criteriaComplete;
            $this->alternatives_complete = $alternativesComplete;
            $this->evaluation_complete = $evaluationComplete;

            // analysis not complete if evaluation changes
            if(!(bool)$evaluationComplete)
            {
                $this->disableAnalysisComplete();
            }

            $this->save();
        }
    }

    /**
     * Find alternatives by weighted score
     *
     * descending
     */
    public function findByWeightedScore()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('rel_model_id=:rel_model_id');
        $criteria->order = 'weightedScore DESC';
        $criteria->params = array('rel_model_id' => $this->model_id);

        return Alternative::model()->findAll($criteria);
    }

    /**
     * Return all decision model's criteria ordered by priority
     *
     * @return Criteria
     */
    public function findCriteriaByPriority()
    {
        // set condition
        $criteriaCondition = new CDbCriteria();
        $criteriaCondition->condition = 'rel_model_id=:rel_model_id';
        $criteriaCondition->params = array(':rel_model_id' => $this->model_id);
        $criteriaCondition->order = 'position ASC';

        return Criteria::model()->findAll($criteriaCondition);
    }

    /**
     * Build an array of grades by alternatives and criteria
     *
     * @param float $quotient
     * @return array
     */
    public function getEvaluationArray($quotient = 0.9)
    {
        // find criteria by priority
        $criteriaArray = $this->findCriteriaByPriority();

        // find alternatives by score
        $alternativeArray = $this->findByWeightedScore();

        // build the array of evaluations
        $eval = array(
            'criteriaNr' => count($criteriaArray),
            'alternativeNr' => count($alternativeArray),
        );

        // loop alternatives
        $i = 0;
        foreach($alternativeArray as $Alternative)
        {
            $eval['Alternatives'][$Alternative->alternative_id] = array(
                'alternative_id'          => $Alternative->alternative_id,
                'title'                   => $Alternative->title,
                'color'					  => $Alternative->color,
                'criteria'                => array(),
                'total'					  => 0,
                'weightedTotal' 		  => 0,
            );

            // init score
            $total = 0;
            $weightedTotal = 0;
            $j = 0; // criteria loop counter

            // loop through criteria
            foreach($criteriaArray as $Criteria)
            {
                // save criteria
                $eval['Alternatives'][$Alternative->alternative_id]['criteria'][$j]['title'] = $Criteria->title;

                // get evaluation for criteria / alternative pair
                $Evaluation = Evaluation::model()->find('rel_criteria_id=:criteriaId AND rel_alternative_id=:alternativeId', array('criteriaId' => $Criteria->criteria_id, 'alternativeId' => $Alternative->alternative_id));

                // save empty evaluation
                if(empty($Evaluation))
                {
                    $Evaluation = new Evaluation();
                    $Evaluation->rel_alternative_id = $Alternative->alternative_id;
                    $Evaluation->rel_criteria_id = $Criteria->criteria_id;
                    $Evaluation->grade = 0;
                    $Evaluation->save();
                }

                // calcualte weight
                $weight = pow($quotient, $j);

                // calculate the score and total
                $score = (int)$Evaluation->grade;
                $total = $total + (int)$Evaluation->grade;

                // calculate weighted score and total
                $weightedScore = $score * $weight;
                $weightedTotal = $weightedTotal + $weightedScore;

                // add evaluation
                $eval['Alternatives'][$Alternative->alternative_id]['criteria'][$j]['weight'] = $weight;
                $eval['Alternatives'][$Alternative->alternative_id]['criteria'][$j]['score'] = $score;
                $eval['Alternatives'][$Alternative->alternative_id]['criteria'][$j]['weightedScore'] = $weightedScore;

                // increase counter
                $j++;
            }

            // addd totals
            $eval['Alternatives'][$Alternative->alternative_id]['total'] = (int)$total;
            $eval['Alternatives'][$Alternative->alternative_id]['weightedTotal'] = (int)$weightedTotal;

            // update scores
            $Alternative->score = $total;
            $Alternative->weightedScore = $weightedTotal;
            $Alternative->save();

            // increase first counter
            $i++;
        }

        // get the order of alternatives (from the database)
        $eval['orderOfAlternatives'] = array();
        foreach($this->findByWeightedScore() as $A)
        {
            array_push($eval['orderOfAlternatives'], $A->alternative_id);
        }

        return $eval;
    }

    /**
     * Check if criteria are complete
     */
    public function checkCriteriaComplete()
    {
        return ((bool)$this->criteria_complete);
    }

    /**
     * Check if alternatives are complete
     */
    public function checkAlternativesComplete()
    {
        return ((bool)$this->alternatives_complete);
    }

    /**
     * Check if evaluation is enabled
     */
    public function checkEvaluateConditions()
    {
        return ((bool)$this->criteria_complete && (bool)$this->alternatives_complete);
    }

    /**
     * Check if evaluation is complete
     */
    public function checkEvaluationComplete()
    {
        return (bool)$this->evaluation_complete;
    }

    /**
     * Check if evaluation is complete
     */
    public function checkAnalysisComplete()
    {
        return (bool)$this->analysis_complete;
    }

    /**
     * Disable analysis complete state
     */
    public function disableAnalysisComplete()
    {
        $this->analysis_complete = 0;
        $this->save();
    }

    /**
     * Get preferred alternative
     */
    public function getPreferredAlternative()
    {
        return Alternative::model()->findByPk($this->preferred_alternative);
    }
}