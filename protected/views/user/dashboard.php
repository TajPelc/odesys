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
                        <dt>Profile feed</dt>
                        <dd>This feed shows yours and your friend's decisions and opinions.</dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>Help others</dt>
                        <dd>You should constantly check what your friends's decision problems are and try to contribute with your opinion on the matter.</dd>
                    </dl>
                </li>
            </ul>
            <span class="helpClose">&nbsp;</span>
            <div id="helpEnd"></div>
        </div>
    </div>
    <ul>
        <?php if(empty($notifications)) { ?>
            <li class="empty">There are no notifications from you nor your friends.</li>
        <?php } else { ?>
            <?php echo $this->renderPartial('dashboard/list', array('notifications' => $notifications)); ?>
        <?php }?>
    </ul>
    <?php if($pagination->getPageCount() > 1) { ?>
    <a class="button" href="#" id="showMore">Show more<span>&nbsp;</span></a>
    <?php } ?>
</div>
<div id="sidebar">
    <div class="edit">
        <h4>Decisions</h4>
        <ul>
            <li><span>My Feed</span></li>
            <li><?php echo CHtml::link('My Decisions', array('project/list')); ?></li>
            <!-- li><a href="#">Statistics</a></li-->
            <!-- li><a href="#">Profile Settings</a></li -->
        </ul>
        <div class="last"></div>
    </div>
</div>
