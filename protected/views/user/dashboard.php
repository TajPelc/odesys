<div id="content">
    <div id="heading">
        <h2>Dashboard - Decision Feed</h2>
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
        <h4>Dashboard Options:</h4>
        <ul>
            <li><?php echo CHtml::link('Decision Feed', array('user/dashboard')); ?></li>
            <li><?php echo CHtml::link('Decision History', array('project/list')); ?></li>
            <li><a href="#">Statistics</a></li>
            <li><a href="#">Profile Settings</a></li>
        </ul>
        <div class="last"></div>
    </div>
</div>
