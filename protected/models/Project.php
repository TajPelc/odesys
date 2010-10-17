<?php

class Project extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
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
            array('title, description', 'required'),
            array('title', 'length', 'max' => 100),
            array('title, description', 'safe', 'on'=>'search'),
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
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            if( $this->isNewRecord )
            {
                // set created
                $this->created = date('Y-m-d H:i:s', time());
                $this->rel_user_id = (Yii::app()->user->isGuest ? User::ANONYMOUS : Yii::app()->user->id);

                // set url until until it's unique
                $this->url = Common::randomString(10);
                while(!$this->isUniqueUrl($this->url))
                {
                    $this->url = Common::randomString(10);
                }
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Handle all the logic after saving
     */
    public function afterSave()
    {
        parent::afterSave();
        $this->setAsActiveProject();
    }

    /**
     * Delete all project related stuff
     */
    public function beforeDelete()
    {
        parent::beforeDelete();

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
     * Get the active project
     */
    public static function getActive()
    {
        // is a project active?
        if(self::isProjectActive())
        {
            $session = Yii::app()->session;
            return Project::model()->findByPk($session['project_id']);
        }
        else
        {
            return false;
        }
    }

    /**
     * Return all project's criteria ordered by priority
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
     */
    public function getEvaluationArrayByCriteria()
    {
        // find criteria by priority
        $criteriaArray = $this->findCriteriaByPriority();

        // build the array of evaluations
        $eval = array();
        foreach($criteriaArray as $Criteria)
        {
            $eval[$Criteria->criteria_id] = array(
                'Obj'                      => $Criteria,
                'Alternatives'             => array(),
            );

            // loop through alternatives
            foreach($this->alternatives as $Alternative)
            {
                // save criteria
                $eval[$Criteria->criteria_id]['Alternatives'][$Alternative->alternative_id]['Obj'] = $Alternative;

                // get all evaluations for this model
                $Evaluation = Evaluation::model()->find('rel_criteria_id=:criteriaId AND rel_alternative_id=:alternativeId', array('criteriaId' =>$Criteria->criteria_id, 'alternativeId' => $Alternative->alternative_id));

                // evaluation does not exist yet
                if(false === $Evaluation instanceof Evaluation)
                {
                    $Evaluation = new Evaluation();
                }

                // add evaluation
                $eval[$Criteria->criteria_id]['Alternatives'][$Alternative->alternative_id]['Evaluation'] = $Evaluation;
            }
        }

        return $eval;
    }

    /**
     * Build an array of grades by alternatives and criteria
     *
     * @param double $quotient
     * @param string $sortBy
     */
    public function getEvaluationArray($quotient = 0.9, $sort = false)
    {
        // build the array of evaluations
        $eval = array();
        foreach($this->alternatives as $Alternative)
        {
            $eval[$Alternative->alternative_id] = array(
                'Obj'                     => $Alternative,
                'Criteria'                => array(),
                'totalPercentage'         => null,
                'weightedTotalPercentage' => null,
            );

            // find criteria by priority
            $criteriaArray = $this->findCriteriaByPriority();

            // init score
            $total = 0;
            $weightedTotal = 0;
            $i = 1;
            // loop through criteria
            foreach($criteriaArray as $Criteria)
            {
                // save criteria
                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['Obj'] = $Criteria;

                // get all evaluations for this model
                $Evaluation = Evaluation::model()->find('rel_criteria_id=:criteriaId AND rel_alternative_id=:alternativeId', array('criteriaId' =>$Criteria->criteria_id, 'alternativeId' => $Alternative->alternative_id));
                // evaluation does not exist yet
                if(false === $Evaluation instanceof Evaluation)
                {
                    $Evaluation = new Evaluation();
                }

                // calcualte weight
                $weight = pow($quotient, $i - 1);

                // calculate the score and total
                $score = $Evaluation->grade * 10;
                $total = $total + $Evaluation->grade * 10;

                // calculate weighted score and total
                $weightedScore = $score * $weight;
                $weightedTotal = $weightedTotal + $weightedScore;

                // add evaluation
                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['Evaluation'] = $Evaluation;
                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['weight'] = $weight;
                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['score'] = $score;
                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['weightedScore'] = $weightedScore;

                // increase counter
                $i++;
            }

            // addd totals
            $eval[$Alternative->alternative_id]['total'] = $total;
            $eval[$Alternative->alternative_id]['weightedTotal'] = (int)$weightedTotal;
        }

        // sort the array
        if($sort)
        {
            uasort($eval, array('Project', 'compareAlternative'));
        }

        return $eval;
    }

    /**
     * Compare two alternatives by weighted score
     *
     * @param array $a
     * @param array $b
     */
    public static function compareAlternative($a, $b)
    {
        if($a['weightedTotal'] == $b['weightedTotal'])
        {
            return 0;
        }

        return ($a['weightedTotal'] < $b['weightedTotal'] ? +1 : -1);
    }

    /**
     * Check if evaluation is enabled
     */
    public function checkEvaluateConditions()
    {
        return (count($this->alternatives) >= 2 && count($this->criteria) >= 2);
    }

    /**
     * Check if evaluation is complete
     */
    public function checkEvaluationComplete()
    {
        $evalCount = count($this->evaluation);
        $criteriaNr = count($this->criteria);
        $alternativeNr = count($this->alternatives);

        return ($criteriaNr >= 2 && $alternativeNr >= 2 && $evalCount == $criteriaNr * $alternativeNr);
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