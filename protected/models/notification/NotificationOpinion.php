<?php

/**
 * This is the model class for table "notification".
 *
 */
class NotificationOpinion extends Notification
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
    public static function add(User $User, Opinion $Opinion)
    {
        $Notification = new self();
        $Notification->rel_user_id = $User->user_id;
        $Notification->time = date('Y-m-d H:i:s');
        $Notification->data = json_encode(array(
            'Decision' => $Opinion->Decision->getAttributes(),
            'Opinion' => $Opinion->getAttributes(),
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

        return '<img src="https://graph.facebook.com/' . $this->User->facebook_id . '/picture" />
            <div>
                <h3>' . ( User::current()->user_id == $this->rel_user_id ? '<a href="' . $this->User->link . '">You</a>' : '<a href="' . $this->User->link . '">' . $this->User->name . '</a>') .  ' - ' . date('M jS, Y \a\t H:i', strtotime($this->time)) . '</h3>
                <p>added a comment to: "<a href="' . $url .  '">' . CHtml::encode($this->data->Decision->title) . '</a>"</p>
                <blockquote>' . CHtml::encode(Common::truncate($this->data->Opinion->opinion, 100)) . '</blockquote>
            </div>';
    }
}