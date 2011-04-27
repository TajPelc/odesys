<?php

class Evaluation extends CActiveRecord
{
    /**
     *  Old values
     */
    private $_oldValues;

    /**
     * The followings are the available columns in table 'evaluation':
     *
     * @var integer $evaluation_id
     * @var integer $rel_project_id
     * @var integer $rel_criteria_id
     * @var integer $rel_alternative_id
     * @var integer $grade
     */

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
            'Project' => array(self::BELONGS_TO, 'Project', 'rel_project_id'),
            'alternative' => array(self::BELONGS_TO, 'Alternative', 'rel_alternative_id'),
            'criteria' => array(self::BELONGS_TO, 'Criteria', 'rel_criteria_id'),
        );
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
     * Handle all the logic before save
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            // update project's last edit
            $this->Project->updateLastEdit();

            // disable project sharing
            $this->Project->analysis_complete = 0;
            $this->Project->disableAnalysisComplete();

            if($this->isNewRecord)
            {
                // increase the number of evaluations
                $this->Project->increase('no_evaluation');
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
        Project::model()->findByPk($this->_oldValues['rel_project_id'])->decrease('no_evaluation');
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'evaluation_id' => 'Evaluation',
            'rel_project_id' => 'Rel Project',
            'rel_criteria_id' => 'Rel Criteria',
            'rel_alternative_id' => 'Rel Alternative',
            'grade' => 'Grade',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('grade',$this->grade);

        return new CActiveDataProvider('Evaluation', array(
            'criteria'=>$criteria,
        ));
    }
}