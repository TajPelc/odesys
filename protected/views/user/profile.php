<?php $this->pageTitle='Profile | Decision feed'; ?>
<div id="content">
    <div id="heading">
        <h2>Profile settings</h2>
        <a id="helpButton" href="#">Help</a>
        <div id="help" style="display: none;">
            <h3>Need some help?</h3>
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
        </div>
    </div>
    <p>By pressing "Delete profile" your Odesys profile will be deleted along with all the data that was created by you.</p>
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
