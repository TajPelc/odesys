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
     * @var string $title
     * @var string $best
     * @var string $worst
     * @var string $description
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
            array('title', 'isProjectUnique'),
            array('title, worst, best', 'required'),
            array('title', 'length', 'max' => 60),
            array('worst, best', 'length', 'max' => 30),
            array('title, description', 'safe', 'on' => 'search'),
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

        return true;
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
                $this->position = count(Criteria::model()->findAllByAttributes(array('rel_project_id' => $this->rel_project_id)));
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Delete criteria related stuff
     */
    public function beforeDelete()
    {
        parent::beforeDelete();

        // delete criteria
        foreach($this->evaluations as $e)
        {
            $e->delete();
        }

        return true;
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