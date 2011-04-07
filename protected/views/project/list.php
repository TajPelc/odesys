<div id="content">
    <h1><?php echo CHtml::link('Dashboard', array('user/dashboard')); ?> &gt; Decision list</h1>

    <dl class="recentDecisions">
        <dt>All my decisions</dt>
        <dd>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Last modified</th>
                    <th>No. alternatives</th>
                    <th>No. criteria</th>
                    <th>No. comments</th>
                    <th>Participants</th>
                    <th>...</th>
                </tr>
                <?php foreach($Decisions as $D) { ?>
                <tr>
                    <td><?php echo CHtml::encode($D->title); ?></td>
                    <td><?php echo date('d.m.Y \o\n H:i', strtotime($D->created)); ?></td>
                    <td><?php echo date('d.m.Y \o\n H:i', strtotime($D->last_edit)); ?></td>
                    <td><?php echo $D->no_alternatives; ?></td>
                    <td><?php echo $D->no_criteria; ?></td>
                    <td>0</td>
                    <td>1</td>
                </tr>
                <?php } ?>
            </table>
        </dd>
    </dl>
</div>