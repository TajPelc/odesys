<?php $this->pageTitle='Profile | Decision feed'; ?>
<div id="content">
    <div id="heading">
        <h2>Profile settings</h2>
    </div>
    <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login')); ?>
    <ul>
        <li>
            <dl>
                <dt>Delete profile</dt>
                <dd>By deleting your profile you will lose all the hard work you have done. If you are sure this is what you want, press "Delete profile" button and confirm it. Keep in mind that this action is irreversible.</dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>Which data gets deleted?</dt>
                <dd>Your profile.</dd>
                <dd>Your decisions.</dd>
                <dd>Your opinions.</dd>
                <dd>Notifications about your actions.</dd>
            </dl>
        </li>
    </ul>

    <span class="helpClose">&nbsp;</span>
    <div id="helpEnd"></div>
    <p>By deleting your profile you will lose all the hard work you have done. If you are sure this is what you want, press "Delete profile" button and confirm it. Keep in mind that this action is irreversible.</p>
    <a href="#" class="buttonBig">Delete profile<span class="doors">&nbsp;</span></a>
</div>
<div id="sidebar">
    <a href="#" class="buttonBig projectNew">Make a new decision<span class="doors">&nbsp;</span></a>
    <div class="edit">
        <ul>
            <li><?php echo CHtml::link('My Feed', array('user/notifications')); ?></li>
            <li><?php echo CHtml::link('My Decisions', array('user/decisions')); ?></li>
            <li><span>Profile Settings</span></li>
        </ul>
        <div class="last"></div>
    </div>
</div>
