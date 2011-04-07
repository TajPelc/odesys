<div id="content">
    <h1>Dashboard</h1>

    <dl class="recentDecisions">
        <dt>My latest decisions</dt>
        <dd>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Last modified</th>
                    <th>No. comments</th>
                    <th>Participants</th>
                </tr>
                <?php foreach($Decisions as $D) { ?>
                <tr>
                    <td><?php echo CHtml::encode($D->title); ?></td>
                    <td><?php echo date('d.m.Y', strtotime($D->last_edit)); ?></td>
                    <td>0</td>
                    <td>1</td>
                </tr>
                <?php } ?>
            </table>
            <?php echo CHtml::link('View all', array('project/view')); ?>
        </dd>
    </dl>
    <dl class="statistics">
        <dt>Statistics</dt>
        <dd class="first">Total number of decisions: <b><?php echo count($User->projects); ?></b></dd>
        <dd>Number of comments from your social circle: <b>0</b></dd>
        <dd>Number of people participating on your projects: <b>0</b></dd>
    </dl>
    <dl class="profile">
        <dt>My profile</dt>
        <dd class="first"><a href="#">Privacy</a></dd>
        <dd><a href="#">Settings</a></dd>
    </dl>
</div>