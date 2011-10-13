<?php

/**
 * This is the model class for table "decision".
 *
 * The followings are the available columns in table 'decision':
 * @property string $decision_id
 * @property string $rel_user_id
 * @property string $title
 * @property string $label
 * @property string $created
 * @property string $last_edit
 * @property string $description
 * @property integer $view_privacy
 * @property integer $opinion_privacy
 *
 * The followings are the available model relations:
 * @property User $relUser
 * @property Model[] $models
 * @property Opinions[] $opinions
 */
class Decision extends CActiveRecord
{
    /**
     * Privacy
     */
    const PRIVACY_EVERYONE = 0;
    const PRIVACY_FRIENDS = 1;
    const PRIVACY_ME = 2;

    /**
     * Returns the static model of the specified AR class.
     * @return Decision
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
        return 'decision';
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
            array('title', 'safe', 'on'=>'search'),

            array('description', 'filter', 'filter' => 'trim'),
            array('description', 'required'),

            array('view_privacy, opinion_privacy', 'numerical', 'min' => 0, 'max' => 2),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'User' => array(self::BELONGS_TO, 'User', 'rel_user_id'),
            'models' => array(self::HAS_MANY, 'DecisionModel', 'rel_decision_id'),
            'opinions' => array(self::HAS_MANY, 'Opinion', 'rel_decision_id'),
            'opinionCount' => array(self::STAT, 'Opinion', 'rel_decision_id'),
        );
    }

    /**
     * Return translations for view privacy constants
     *
     * @TODO Add translations!
     * @return string
     */
    public function getViewPrivacyLabel()
    {
        $labels = array(
            self::PRIVACY_EVERYONE => 'Everyone',
            self::PRIVACY_FRIENDS => CHtml::encode($this->User->first_name). '\'s friends',
            self::PRIVACY_ME => 'Only you',
        );

        return $labels[$this->view_privacy];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'decision_id' => 'Decision',
            'rel_user_id' => 'Rel User',
            'title' => 'Title',
            'label' => 'Label',
            'created' => 'Created',
            'last_edit' => 'Last Edit',
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
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Handle all the logic before saving
     *
     * - set created time and label for new records
     * - update last edit time
     */
    public function beforeSave()
    {
        if(parent::beforeSave())
        {
            // new record
            if( $this->isNewRecord )
            {
                $this->created = date('Y-m-d H:i:s', time());
                $this->label = Common::toAscii($this->title, array('’', '\''));
                $this->label = strlen($this->label) > 0 ? $this->label : 'my-decision';
            }
            $this->updateLastEdit(false);

            // opinion privacy cannot be more open than view privacy
            if($this->opinion_privacy < $this->view_privacy)
            {
                $this->opinion_privacy = $this->view_privacy;
            }
            return true;
        }
        return false;
    }

    /**
     * Delete all decision related stuff
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            // delete decision models and opinions
            foreach(array_merge($this->models, $this->opinions) as $m)
            {
                $m->delete();
            }
            return true;
        }
        return false;
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
     * Get active decision model
     */
    public function getActiveDecisionModel()
    {
        return DecisionModel::model()->findByAttributes(array('rel_decision_id' => $this->decision_id, 'status' => DecisionModel::ACTIVE));
    }

    /**
     * Get published decision model
     */
    public function getPublishedDecisionModel()
    {
        return DecisionModel::model()->findByAttributes(array('rel_decision_id' => $this->decision_id, 'status' => DecisionModel::PUBLISHED));
    }

    /**
     * Create active decision model
     */
    public function createActiveDecisionModel()
    {
        // create a new decision model
        $DecisionModel = new DecisionModel();
        $DecisionModel->rel_decision_id = $this->decision_id;
        $DecisionModel->status = DecisionModel::ACTIVE;
        $DecisionModel->save();

        return $DecisionModel;
    }

    /**
     * Publish the current active decision model and create a new active decision model
     */
    public function publishDecisionModel()
    {
        // check if the decision model is already published
        $isPublished = $this->isPublished();

        // get active decision model
        $Active = $this->getActiveDecisionModel();

        // copy the active decision model
        $New = new DecisionModel();
        $New->setAttributes($Active->getAttributes(), false);
        unset($New->model_id);
        $New->insert();

        // publish the old decision model
        $Active->status = DecisionModel::PUBLISHED;
        $Active->save();

        // create a hash table with mapping
        $mapper = array(
            'alternatives' => array(),
            'criteria'	=> array(),
        );

        // clone alternatives
        foreach($Active->alternatives as $Alt)
        {
            $newAlt = new Alternative();
            $newAlt->setAttributes($Alt->getAttributes(), false);
            $newAlt->clone = true;
            unset($newAlt->alternative_id);
            $newAlt->rel_model_id = $New->model_id;
            $newAlt->insert();

            // set prefered alternative for the new decision model
            if($Alt->getPrimaryKey() == $Active->preferred_alternative)
            {
                $New->preferred_alternative = $newAlt->getPrimaryKey();
                $New->save();
            }

            // save old id => new id
            $mapper['alternatives'][$Alt->alternative_id] = $newAlt->alternative_id;
        }

        // clone criteria
        foreach($Active->criteria as $Cri)
        {
            $newCri = new Criteria();
            $newCri->setAttributes($Cri->getAttributes(), false);
            $newCri->clone = true;
            unset($newCri->criteria_id);
            $newCri->rel_model_id = $New->model_id;
            $newCri->insert();

            // save old id => new id
            $mapper['criteria'][$Cri->criteria_id] = $newCri->criteria_id;
        }

        // clone evaluation
        foreach($mapper['criteria'] as $oldCriId => $newCriId)
        {
            foreach($mapper['alternatives'] as $oldAltId => $newAltId)
            {
                // load old evaluation
                $Evaluation = Evaluation::model()->findByPk(array('rel_alternative_id' => $oldAltId, 'rel_criteria_id' => $oldCriId));

                // create new evaluation
                $newEvaluation = new Evaluation();
                $newEvaluation->clone = true;
                $newEvaluation->rel_alternative_id = $newAltId;
                $newEvaluation->rel_criteria_id = $newCriId;
                $newEvaluation->grade = $Evaluation->grade;
                $newEvaluation->insert();
            }
        }

        // save published decision model to saved
        $condition = new CDbCriteria();
        $condition->condition = 'rel_decision_id = :rel_decision_id AND status = :status AND model_id != :model_id';
        $condition->params  = array(
            'rel_decision_id' => $this->getPrimaryKey(),
            'status' => DecisionModel::PUBLISHED,
            'model_id' => $Active->getPrimaryKey(),
        );

        // archive old published
        foreach(DecisionModel::model()->findAll($condition) as $M)
        {
            $M->status = DecisionModel::ARCHIVED;
            $M->save();
        }

        // not already published
        if(!$isPublished)
        {
            // add notification
            NotificationDecision::publish($this->User, $this);
        }
    }

    /**
     * Publish the current active decision model and create a new active decision model
     */
    public function getAllOpinions($page, $pageSize = 10)
    {
        // get opinions
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'rel_decision_id=:rel_decision_id';
        $Criteria->order = 'created DESC';
        $Criteria->params = array('rel_decision_id' => $this->decision_id);

        // set pagination
        $Pagination = new CPagination();
        $Pagination->setItemCount(Opinion::model()->count($Criteria));
        $Pagination->setCurrentPage($page);
        $Pagination->setPageSize($pageSize);
        $Pagination->applyLimit($Criteria);

        return array(
            'pagination' => $Pagination,
            'models' => Opinion::model()->findAll($Criteria),
        );
    }

    /**
     * Check if the given user is the owner
     *
     * @param $userId
     * @return boolean
     */
    public function isOwner($userId)
    {
        return ($this->rel_user_id == $userId);
    }

    /**
     * Check if this decision is published
     *
     * (had a published decision model)

     * @return boolean
     */
    public function isPublished()
    {
        return (bool) $this->getPublishedDecisionModel();
    }

    /**
     * Check if this decision is public
     *
     * @return boolean
     */
    public function isPublic()
    {
        return ($this->view_privacy == self::PRIVACY_EVERYONE);
    }

    /**
     * Check if this decision is friends only
     *
     * @return boolean
     */
    public function isFriendsOnly()
    {
        return ($this->view_privacy == self::PRIVACY_FRIENDS);
    }

    /**
     * Check if this decision is private
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return ($this->view_privacy == self::PRIVACY_ME);
    }
}