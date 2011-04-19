<?php

class Project extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Project
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
        return 'project';
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
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
          'user'            => array(self::BELONGS_TO,  'User',         'rel_user_id'),
          'alternatives'    => array(self::HAS_MANY,    'Alternative',  'rel_project_id'),
          'criteria'        => array(self::HAS_MANY,    'Criteria',     'rel_project_id'),
          'evaluation'      => array(self::HAS_MANY,    'Evaluation',   'rel_project_id'),
        );
    }

    /**
     * Handle all the logic before saving
     */
    public function beforeValidate()
    {
        if( parent::beforeValidate() )
        {
            if( $this->isNewRecord )
            {
                // set created
                $this->created = date('Y-m-d H:i:s', time());
                $this->rel_user_id = Yii::app()->user->id;

            }
            return true;
        }
        return false;
    }

    /**
     * Handle all the logic before saving
     */
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->updateLastEdit(false);
            return true;
        }
        return false;
    }

    /**
     * Handle all the logic after saving
     */
    public function afterSave()
    {
        $this->setAsActiveProject();
    }

    /**
     * Delete all project related stuff
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            // delete evaluations
            foreach($this->evaluation as $e)
            {
                $e->delete();
            }

            // delete alternatives
            foreach($this->alternatives as $a)
            {
                $a->delete();
            }

            // delete criteria
            foreach($this->criteria as $c)
            {
                $c->delete();
            }

            return true;
        }
        return false;
    }

    /**
     * Make this project active
     */
    public function setAsActiveProject()
    {
        $session = Yii::app()->session;
        $session['project_id'] = $this->project_id;
    }

    /**
     * Unset the active project
     */
    public static function unsetActiveProject()
    {
        $session = Yii::app()->session;
        unset($session['project_id']);
    }

    /**
     * Is a project active?
     */
    public static function isProjectActive()
    {
        $session = Yii::app()->session;
        return isset($session['project_id']);
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
     * Evaluate the conditions for the different steps of the project
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
            && ((int)$this->no_evaluation > ($nrOfExpectedEvaluations - $this->no_criteria + 1))
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
            $this->save();
        }
    }

    /**
     * Get the active project
     */
    public static function getActive()
    {
        // is a project active?
        if(self::isProjectActive())
        {
            $session = Yii::app()->session;
            $model = Project::model()->findByPk($session['project_id']);
            if(empty($model))
            {
                $this->unsetActiveProject();
                return false;
            }

            return $model;
        }
        return false;
    }

    /**
     * Find alternatives by weighted score
     *
     * descending
     */
    public function findByWeightedScore()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('rel_project_id=:rel_project_id');
        $criteria->order = 'weightedScore DESC';
        $criteria->params = array('rel_project_id' => $this->project_id);

        return Alternative::model()->findAll($criteria);
    }

    /**
     * Return all project's criteria ordered by priority
     *
     * @return Criteria
     */
    public function findCriteriaByPriority()
    {
        // set condition
        $criteriaCondition = new CDbCriteria();
        $criteriaCondition->condition = 'rel_project_id=:rel_project_id';
        $criteriaCondition->params = array(':rel_project_id' => $this->project_id);
        $criteriaCondition->order = 'position ASC';

        return Criteria::model()->findAll($criteriaCondition);
    }

    /**
     * Build an array of grades by alternatives and criteria
     *
     * @param double $quotient
     * @param string $sortBy
     */
    public function getEvaluationArray($quotient = 0.9)
    {
        // find criteria by priority
        $criteriaArray = $this->findCriteriaByPriority();

        // build the array of evaluations
        $eval = array(
            'criteriaNr' => count($criteriaArray),
        );

        // loop alternatives
        $i = 0;
        foreach($this->findByWeightedScore() as $Alternative)
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
     * Create a url to view this project
     *
     * @return string
     */
    public function getUrl()
    {
        return Yii::app()->createUrl('project/view', array(
            'id' => $this->project_id,
            'title' => $this->title,
        ));
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels()
    {
        return array(
          'project_id'      => 'Project',
          'title'           => 'Title',
          'description'     => 'Description',
          'created'         => 'Created',
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
        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider('Project', array(
          'criteria'=>$criteria,
        ));
    }

    /**
     * Checks if url is unique
     * @return boolean
     */
    public function isUniqueUrl($url)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'url=:url';
        $criteria->params = array(':url' => $url);

        return !self::model()->exists($criteria);
    }
}