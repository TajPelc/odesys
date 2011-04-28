<?php

/**
 * This is the abstract model for decision elements
 */
abstract class DecisionElement extends CActiveRecord
{
    /**
     *  Old values
     */
    protected $_oldValues = array();

    /**
     * Clone
     */
    protected $clone = false;

    /**
     * Check if title is unique for this decision
     *
     * @param $attribute
     * @param $params
     */
    public function isDecisionModelUnique($attribute, $params)
    {
        // check for new records or if the title has been changed
        if($this->getIsNewRecord() || $this->_oldValues['title'] !== $this->title)
        {
            // editing
            if(!$this->getIsNewRecord() && mb_strtolower($this->title, mb_detect_encoding($this->title)) == mb_strtolower($this->_oldValues['title'], mb_detect_encoding($this->_oldValues['title'])) )
            {
                return true;
            }

            // record exists!
            if(null !== $this->findByAttributes(array('rel_model_id' => $this->rel_model_id, $attribute => $this->{$attribute})))
            {
                $this->addError($attribute, ucfirst($attribute).' must be unique.');
            }
        }
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
     * Before delete
     *
     * Update decision model's last edit date and delete all evaluation
     */
    public function beforeDelete()
    {
        if( parent::beforeDelete() )
        {
            // update decision model's last edit
            $this->DecisionModel->updateLastEdit();

            // delete criteria
            foreach($this->evaluations as $e)
            {
                $e->delete();
            }
            return true;
        }

        return false;
    }
}