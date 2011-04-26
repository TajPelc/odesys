<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Overview'; ?>
<div id="content">
    <?php echo CHtml::link('Edit project details', array('project/create'), array('class' => 'button', 'id' => 'create')); ?>
    <?php echo CHtml::link('Export data to Microsoft Excel', array('export/index'), array('class' => 'button', 'id' => 'export')); ?>

    <?php if(is_array($eval) && count($eval) > 0) {?>
    <?php $first = array_slice($eval, 0, 1, true); ?>
    <?php $first = current($first); ?>
    <dl id="highestScore">
        <dt>Highest scoring alternative:</dt>
        <dd><span><?php echo CHtml::encode($first['Obj']->title);?></span><span><?php echo $first['weightedTotal'];?> points</span></dd>
    </dl>
    <dl id="showProjectDescription">
        <dt>Project description:</dt>
        <dd><?php echo nl2br(CHtml::encode($Project->description));?></dd>
    </dl>
    <?php }?>
</div>

<div id="sidebar">
    <ul>
        <li><p><i>Nr. of criteria:</i><span><?php echo (is_array($Criteria) && count($Criteria) > 0 ? (string)count($Criteria) : '0') ?></span></li>
        <li><p><i>Nr. of alternatives:</i><span><?php echo (is_array($Alternatives) && count($Alternatives) > 0 ? (string)count($Alternatives) : '0') ?></span></li>
        <li><p>Are you now able to decide?</p></li>
        <li><p>You may return to a previous step at any time.</p></li>
        <li><p>Share the URL to enable other people to acces your project.</p></li>
        <li><p>Important! Save the URL or add it to the bookmarks or you won't be able to access the project at a later time.</p></li>
    </ul>
    <span class="left">&nbsp;</span>
</div>

<h2>Alternatives by rank</h2>
<table>
    <tr>
        <th>Rank</th>
        <th>Name</th>
        <th>Weighted score</th>
        <th>Unweighted score</th>
    </tr>
    <?php $i = 1;?>
    <?php foreach($eval as $A) { ?>
        <tr>
            <td class="c"><?php echo $i; ?>.</td>
            <td class="f"><?php echo CHtml::encode($A['Obj']->title); ?></td>
            <td><?php echo $A['weightedTotal']; ?></td>
            <td><?php echo $A['total']; ?></td>
        </tr>
        <?php $i++;?>
    <?php }?>
</table>
<h2>Alternatives by criteria</h2>
<table>
    <?php foreach($eval as $A) { ?>
    <tr>
        <th>&nbsp;</th>
        <?php foreach($A['Criteria'] as $C) { ?>
            <th><?php echo CHtml::encode($C['Obj']->title); ?></th>
        <?php }?>
        <?php break;?>
    </tr>
    <?php }?>
    <?php foreach($eval as $A) { ?>
    <tr>
        <th class="f"><?php echo CHtml::encode($A['Obj']->title) ?></th>
        <?php foreach($A['Criteria'] as $C) { ?>
            <td><?php echo (string)$C['Evaluation']->grade; ?></td>
        <?php }?>
    </tr>
    <?php }?>
</table>
<h2>Criteria details</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Least desired value</th>
        <th>Most desired value</th>
        <th>Weight</th>
    </tr>
    <?php foreach($Criteria as $C) { ?>
        <tr>
            <td><?php echo CHtml::encode($C->title)?></td>
            <td>&nbsp;</td>
        </tr>
    <?php }?>
</table>