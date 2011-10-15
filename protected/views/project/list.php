<?php $this->pageTitle='Profile | Decision history'; ?>
<div id="content">
    <div id="heading">
        <h2>Decision history</h2>
    </div>
    <?php if(!empty($Decisions)) { ?>
    <table>
        <tr>
            <th>Decision name</th>
            <th>Last modified</th>
            <th>No. opinions</th>
            <th>Published</th>
        </tr>
        <?php foreach($Decisions as $D) { ?>
        <tr id="<?php echo $D->decision_id; ?>">
            <td><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '.html'); ?></td>
            <td><?php echo date('j.n.Y', strtotime($D->last_edit)); ?></td>
            <td><?php echo $D->opinionCount; ?></td>
            <td><div><?php echo ($D->isPublished() ? 'Yes' : 'No'); ?><span>X</span></div></td>
        </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
    <h3>You don't have any decisions yet. Start by creating one.</h3>
    <?php } ?>
</div>
<div id="sidebar">
    <div class="edit">
        <h4>Decisions</h4>
        <ul>
            <li><?php echo CHtml::link('My Feed', array('user/dashboard')); ?></li>
            <li><span>My Decisions</span></li>
            <!-- li><a href="#">Statistics</a></li -->
            <!-- li><a href="#">Profile Settings</a></li -->
        </ul>
        <div class="last"></div>
    </div>
</div>
