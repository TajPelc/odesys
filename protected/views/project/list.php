<div id="content">
    <div id="heading">
        <h2>Decision History</h2>
    </div>
    <table>
        <tr>
            <th>Decision name</th>
            <th>Last modified</th>
            <th>No. comments</th>
        </tr>
        <?php foreach($Decisions as $D) { ?>
        <tr>
            <td><?php echo CHtml::link(CHtml::encode($D->title), array('/decision/analysis', 'decisionId' => $D->decision_id, 'label' => $D->label)); ?></td>
            <!-- td><?php echo date('j.n.Y', strtotime($D->created)); ?></td-->
            <td><?php echo date('j.n.Y', strtotime($D->last_edit)); ?></td>
            <!-- td><?php echo $D->getActiveDecisionModel()->no_alternatives; ?></td-->
            <!-- td><?php echo $D->getActiveDecisionModel()->no_criteria; ?></td-->
            <td>0</td>
        </tr>
        <?php } ?>
    </table>
</div>
<div id="sidebar">
    <div class="edit">
        <h4>Dashboard Options:</h4>
        <ul>
            <li><?php echo CHtml::link('Decision Feed', array('user/dashboard')); ?></li>
            <li><a href="#">Decision History</a></li>
            <li><a href="#">Statistics</a></li>
            <li><a href="#">Profile Settings</a></li>
        </ul>
        <div class="last"></div>
    </div>
</div>
