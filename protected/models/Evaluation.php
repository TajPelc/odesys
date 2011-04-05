<?php

class Evaluation extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'evaluation':
     * @var double $evaluation_id
     * @var double $rel_criteria_id
     * @var double $rel_alternative_id
     * @var integer $grade
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
            'project' => array(self::BELONGS_TO, 'Project', 'rel_project_id'),
            'alternative' => array(self::BELONGS_TO, 'Alternative', 'rel_alternative_id'),
            'criteria' => array(self::BELONGS_TO, 'Criteria', 'rel_criteria_id'),
        );
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