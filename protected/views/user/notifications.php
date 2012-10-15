<?php $this->pageTitle='Profile | Decision feed'; ?>
<div id="content">
    <div id="heading">
        <h2>Decision feed</h2>
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
    <ul>
        <?php if(empty($notifications)) { ?>
            <li class="empty">You have no notifications.</li>
        <?php } else { ?>
            <?php echo $this->renderPartial('notifications/list', array('notifications' => $notifications)); ?>
        <?php }?>
    </ul>
    <?php if(isset($pagination) && $pagination->getPageCount() > 1) { ?>
    <a class="button" href="#" id="showMore">Show more<span>&nbsp;</span></a>
    <?php } ?>
</div>
<div id="sidebar">
    <a href="#" class="buttonBig projectNew">Make a new decision<span class="doors">&nbsp;</span></a>
    <div class="edit">
        <ul>
            <li><span>My Feed</span></li>
            <li><?php echo CHtml::link('My Decisions', array('user/decisions')); ?></li>
            <li><?php echo CHtml::link('Profile Settings', array('user/profile')); ?></li>
        </ul>
        <div class="last"></div>
    </div>
</div>
