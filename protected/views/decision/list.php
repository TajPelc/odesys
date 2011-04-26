<div id="content">
    <h1><?php echo CHtml::link('Dashboard', array('user/dashboard')); ?> &gt; Decision list</h1>

    <dl class="recentDecisions">
        <dt>All my decisions</dt>
        <dd>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Last<br /> modified</th>
                    <th>No. alternatives</th>
                    <th>No. criteria</th>
                    <th>No. comments</th>
                    <th>Participants</th>
                </tr>
                <?php foreach($Decisions as $D) { ?>
                <tr>
                    <td><?php echo CHtml::link(CHtml::encode($D->title), array('project/activate', 'id' => $D->project_id)); ?></td>
                    <td><?php echo date('j.n.Y', strtotime($D->created)); ?></td>
                    <td><?php echo date('j.n.Y', strtotime($D->last_edit)); ?></td>
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
