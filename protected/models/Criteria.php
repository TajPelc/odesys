<?php

class Criteria extends CActiveRecord
{
    /**
     *  Old title for uniqueness comparison
     */
    private $oldTitle;

    /**
     * The followings are the available columns in table 'criteria':
     * @var double $criteria_id
     * @var double $rel_project_id
     * @var string $position
     * @var string $title
     */

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
            array('title', 'isProjectUnique'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'project' => array(self::BELONGS_TO, 'Project', 'rel_project_id'),
            'evaluations' => array(self::HAS_MANY, 'Evaluation', 'rel_criteria_id'),
        );
    }

    /**
     * Check if title is unique for this project
     *
     * @param $attribute
     * @param $params
     */
    public function isProjectUnique($attribute, $params)
    {
        // check for new records or if the title has been changed
        if($this->getIsNewRecord() || $this->oldTitle !== $this->title)
        {
            // editing
            if(!$this->getIsNewRecord() && mb_strtolower($this->title, mb_detect_encoding($this->title)) == mb_strtolower($this->oldTitle, mb_detect_encoding($this->oldTitle)) )
            {
                return true;
            }

            // record exists!
            if(null !== $this->findByAttributes(array('rel_project_id' => $this->rel_project_id, $attribute => $this->{$attribute})))
            {
                $this->addError($attribute, ucfirst($attribute).' must be unique.');
            }
        }
    }

    /**
     * Save the title value for later comparison
     */
    public function afterFind()
    {
        parent::afterFind();

        // save old title
        $this->oldTitle = $this->title;
    }

    /**
     * Handle all the logic before validation
     */
    public function beforeValidate()
    {
        if( parent::beforeValidate() )
        {
            if( $this->isNewRecord )
            {
                $this->rel_project_id = Project::getActive()->project_id;
                $this->position = Project::getActive()->no_criteria;
            }
            return true;
        }
        return false;
    }

    /**
     * Handle all the logic before save
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            if($this->isNewRecord)
            {
                // increase the number of criteria
                Project::getActive()->increase('no_criteria');
            }
            return true;
        }
        return false;
    }

    /**
     * Delete evaluations
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            // delete criteria
            foreach($this->evaluations as $e)
            {
                $e->delete();
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

        // create query criteria
        $dbCriteria= new CDbCriteria();
        $dbCriteria->condition = 'rel_project_id = :rel_project_id';
        $dbCriteria->order = 'position ASC';
        $dbCriteria->params = array(':rel_project_id' => Project::getActive()->project_id);

        // query
        $result = self::model()->findAll($dbCriteria);

        // reorder and save
        for($i = 0; $i < count($result); $i++)
        {
            $result[$i]->position = $i;
            $result[$i]->save();
        }

        // decrease the number of criteria
        Project::getActive()->decrease('no_criteria');
    }

    /**
     * Return criteria for the current project matching the position given
     *
     * @param int $position
     */
    public static function getCriteriaByPosition($position)
    {
        return self::model()->findByAttributes(array('rel_project_id' => Project::getActive()->project_id, 'position' => $position));
    }

    /**
     * Check if this decision is evaluated by current criteria
     *
     * @param int $position
     */
    public function isDecisionEvaluated()
    {
        // if there are the same number of evaluations with this criteria and project id as there are alternatives, then this criteria has been evaluated
        return (Project::getActive()->no_alternatives == Evaluation::model()->countByAttributes(array('rel_project_id' => $this->rel_project_id, 'rel_criteria_id' => $this->criteria_id)));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'criteria_id' => 'Criteria',
            'rel_project_id' => 'Rel Project',
            'position' => 'Position',
            'title' => 'Title',
            'best' => 'Best',
            'worst' => 'Worst',
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

        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider('Criteria', array(
            'criteria'=>$criteria,
        ));
    }
}