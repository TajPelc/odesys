<?php
$this->breadcrumbs = array(
    'Edit project details' => array('project/create', 'project_id' => $Project->project_id),
    'Define criteria',
    'Define alternatives' => array('alternative/create'),
    'Evaluation' => array('evaluation/evaluate'),
    'Results' => array('results/display'),
);
?>

<h1>Define criteria</h1>
<p>Click add to add a criteria, click next to finish adding and continue with the process.</p>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<?php $Criteria = $Project->findCriteriaByPriority(); ?>
<h2>Criteria</h2>
<p>You may drag each criteria up or down to rearrange the list by priority.</p>
<div id="criteria">
    <?php if(Common::isArray($Criteria)) {?>
        <ul id="sortable">
            <?php foreach($Criteria as $C) {?>
                <li id="criteria_<?php echo $C->criteria_id; ?>"><?php echo CHtml::encode($C->title); ?> <span><a href="<?php echo $this->createUrl('create', array('criteria_id' => $C->criteria_id)); ?>">edit</a> | <a href="<?php echo $this->createUrl('delete', array('criteria_id' => $C->criteria_id)); ?>">delete</a></span></li>
            <?php }?>
        </ul>
    <?php } else { ?>
        <p class="notice">No criteria yet defined.</p>
    <?php }?>
</div>