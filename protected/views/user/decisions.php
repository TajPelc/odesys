<?php $this->pageTitle='Profile | Decision history'; ?>
<div id="content">
    <div id="heading">
        <h2>Decision history</h2>
        <a id="helpButton" href="#">Help</a>
        <div id="help" style="display: none;">
            <h3>Need some help?</h3>
            <ul>
                <li>
                    <dl>
                        <dt>Your decision history</dt>
                        <dd>A full list of your decisions is displayed. You can click a decision name to reach its report and further edit it from there.</dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>Can I delete a decision?</dt>
                        <dd>Yes, you can. Delete button appears if you hover over a decision. Beware, deleting a decision is an ireversible action.</dd>
                    </dl>
                </li>
            </ul>
            <span class="helpClose">&nbsp;</span>
            <div id="helpEnd"></div>
        </div>
    </div>
    <?php if(!empty($Decisions)) { ?>
    <table>
        <tr>
            <th>Decision name</th>
            <th>Last modified</th>
            <th>No. opinions</th>
            <th>Published to</th>
            <th class="l"></th>
        </tr>
        <?php foreach($Decisions as $D) { ?>
        <tr id="<?php echo $D->decision_id; ?>">
            <td><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '.html'); ?></td>
            <td><?php echo date('j.n.Y', strtotime($D->last_edit)); ?></td>
            <td><?php echo $D->opinionCount; ?></td>
            <td>
                <div>
                    <?php
                    if($D->isPublished()) {
                        if($D->isPrivate()) {
                            echo 'Private';
                        } elseif ($D->isFriendsOnly()) {
                            echo 'Friends';
                        } elseif ($D->isPublic()) {
                            echo 'Everyone';
                        }
                    } else {
                        echo '<em>Not yet</em>';
                    }?>
                </div>
            </td>
            <td class="l"><div><span>X</span></div></td>
        </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
    <h3>You don't have any decisions yet. Start by creating one.</h3>
    <?php } ?>
</div>
<div id="sidebar">
    <a href="#" class="buttonBig projectNew">Make a new decision<span class="doors">&nbsp;</span></a>
    <div class="edit">
        <ul>
            <li><?php echo CHtml::link('My Feed', array('user/notifications')); ?></li>
            <li><span>My Decisions</span></li>
            <!-- li><a href="#">Statistics</a></li -->
            <!-- li><a href="#">Profile Settings</a></li -->
        </ul>
        <div class="last"></div>
    </div>
</div>
