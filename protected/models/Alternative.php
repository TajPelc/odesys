<?php

class Alternative extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'alternative':
     * @var double $alternative_id
     * @var double $rel_project_id
     * @var string $title
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
        return 'alternative';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 85),
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
            'evaluations' => array(self::HAS_MANY, 'Evaluation', 'rel_alternative_id'),
        );
    }

    /**
     * Delete alternative related stuff
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
            'alternative_id' => 'Alternative',
            'rel_project_id' => 'Rel Project',
            'title' => 'Title',
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

        return new CActiveDataProvider('Alternative', array(
            'criteria'=>$criteria,
        ));
    }
}