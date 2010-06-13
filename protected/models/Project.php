<?php

class Project extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'project':
     * @var bigint $project_id
     * @var bigint $rel_user_id
     * @var string $title
     * @var string $description
     * @var string $created
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
                $this->created = date('Y-m-d H:i:s', time());
                $this->rel_user_id = Yii::app()->user->id;
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
     * Build an array of grades by alternatives and criteria
     */
    public function getEvaluationArray()
    {
        // build the array of evaluations
        $eval = array();
        foreach($this->alternatives as $Alternative)
        {
            $eval[$Alternative->alternative_id] = array(
                'Obj'           => $Alternative,
                'Criteria'      => array(),
            );

            foreach($this->criteria as $Criteria)
            {
                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['Obj'] = $Criteria;

                $Evaluation = Evaluation::model()->find('rel_criteria_id=:criteriaId AND rel_alternative_id=:alternativeId', array('criteriaId' =>$Criteria->criteria_id, 'alternativeId' => $Alternative->alternative_id));
                if(false === $Evaluation instanceof Evaluation)
                {
                    $Evaluation = new Evaluation();
                }

                $eval[$Alternative->alternative_id]['Criteria'][$Criteria->criteria_id]['Evaluation'] = $Evaluation;
            }
        }

        return $eval;
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
}