<?php

/**
 * This is the model class for table "notification".
 *
 */
class NotificationDecision extends Notification
{
    /**
     * Init the model(non-PHPdoc)
     * @see CActiveRecord::init()
     */
    public function init()
    {
        $this->type = self::DECISION;
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
     * Add notification
     * @param User $User
     * @param Decision $Decision
     */
    public static function publish(User $User, Decision $Decision)
    {
        $Notification = new self();
        $Notification->rel_user_id = $User->user_id;
        $Notification->time = date('Y-m-d H:i:s');
        $Notification->data = json_encode(array(
            'privacy' => $Decision->getViewPrivacyLabel(),
            'Decision' =>  $Decision->getAttributes(),
        ));
        $Notification->save();

        return $Notification;
    }

    /**
     * Return a string
     */
    public function __toString()
    {
        $url = '/decision/'. $this->data->Decision->decision_id . '-' . $this->data->Decision->label . '.html';

        return '<img src="https://graph.facebook.com/' . $this->User->facebook_id . '/picture" title="' . $this->User->name . '" alt="' . $this->User->name . '" />
            <div>
                <h3>' . ( User::current()->user_id == $this->rel_user_id ? '<a href="' . $this->User->link . '">You</a>' : '<a href="' . $this->User->link . '">' . $this->User->name . '</a>') .  ' - ' . date('F jS, Y \a\t H:i', strtotime($this->time)) . '</h3>
                <p>published a decision: "<a href="' . $url .  '">' . CHtml::encode($this->data->Decision->title) . '</a>" to <b>' . strtolower($this->data->privacy) . '</b></p>
            </div>';
    }
}