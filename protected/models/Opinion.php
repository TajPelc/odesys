<?php

/**
 * This is the model class for table "opinions".
 *
 * The followings are the available columns in table 'opinions':
 * @property string $opinion_id
 * @property string $rel_user_id
 * @property string $rel_decision_id
 * @property string $opinion
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $User
 * @property Decision $Decision
 */
class Opinion extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Opinions
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
        return 'opinion';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('opinion', 'filter', 'filter' => 'trim'),
            array('opinion', 'required'),
            array('opinion', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'User' => array(self::BELONGS_TO, 'User', 'rel_user_id'),
            'Decision' => array(self::BELONGS_TO, 'Decision', 'rel_decision_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'opinion_id' => 'Opinion',
            'rel_user_id' => 'Rel User',
            'rel_decision_id' => 'Rel Decision',
            'opinion' => 'Opinion',
            'created' => 'Created',
        );
    }

    /**
     * Handle all the logic before save
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            // new record?
            if($this->isNewRecord)
            {
                $this->created = date('Y-m-d H:i:s', time());
            }
            return true;
        }
        return false;
    }

    /**
     * After save, add notification
     * @see CActiveRecord::afterSave()
     */
    public function afterSave()
    {
        parent::afterSave();

        // add notification
        NotificationOpinion::add($this->User, $this);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('opinion',$this->opinion,true);
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
}