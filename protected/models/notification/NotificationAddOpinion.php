<?php

/**
 * This is the model class for table "notification".
 *
 */
class NotificationAddOpinion extends Notification
{
    /**
     * Init the model(non-PHPdoc)
     * @see CActiveRecord::init()
     */
    public function init()
    {
        $this->type = self::ADD_OPINION;
    }

    /**
     * Add notification
     * @param User $User
     * @param Decision $Decision
     */
    public static function add(User $User, Decision $Decision)
    {
        $Notification = new self();
        $Notification->rel_user_id = $User->user_id;
        $Notification->time = date('Y-m-d H:i:s');
        $Notification->data = json_encode(array(
            'Decision' => $Decision->getAttributes(),
            'privacy' => $Decision->getViewPrivacyLabel(),
        ));
        $Notification->save();

        return $Notification;
    }

    /**
     * Return a string
     */
    public function __toString()
    {
        $Data = json_decode($this->data);
        $url = '/decision/'. $Data->Decision->decision_id . '-' . $Data->Decision->label . '.html';

        return '<div>
                <h3><a href="' . $this->User->link . '">' . $this->User->name . '</a> - ' . date('M jS, Y', strtotime($this->time)) . '</h3>
                <p>published a decision: "<a href="' . $url .  '">' . CHtml::encode($Data->Decision->title) . '</a>" to <b>' . strtolower($Data->privacy) . '</b>.</p>
        </div>';
    }
}