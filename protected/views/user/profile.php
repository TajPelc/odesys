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
                        <dt>Odesys Feed</dt>
                        <dd>This feed shows yours and your friend's decisions and opinions.</dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>Join others</dt>
                        <dd>By regularly checking your feed, you can see what your friends's decision problems are and you can contribute with your opinion on the matter.</dd>
                    </dl>
                </li>
            </ul>
            <span class="helpClose">&nbsp;</span>
            <div id="helpEnd"></div>
        </div>
    </div>
    <p>By pressing "Delete profile" your Odesys profile will be deleted along with all your decisions.</p>
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
