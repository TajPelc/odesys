<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property string $notification_id
 * @property string $rel_user_id
 * @property integer $type
 * @property integer $source_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $relUser
 */
class Notification extends CActiveRecord
{
    const PUBLISH_DECISION = 1;
    const ADD_OPINION = 2;

    /**
     * Type of notification
     * @var integer
     */
    private $type;

    /**
     * Decode the json string
     * @see CActiveRecord::afterFind()
     */
    public function afterFind()
    {
        $this->data = json_decode($this->data);
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Notification the static model class
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
        return 'notification';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'User' => array(self::BELONGS_TO, 'User', 'rel_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'notification_id' => 'Notification',
            'rel_user_id' => 'Rel User',
            'type' => 'Type',
            'created' => 'Created',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
    }
}