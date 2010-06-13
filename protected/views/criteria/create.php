<?php
$this->breadcrumbs = array(
    $Project->title => array('project/create', 'project_id' => $Project->project_id),
    'Define criteria',
);
?>

<h1>Define criteria</h1>
<p>Add criteria by importance from most to least important. Click add to add a criteria, click next to finish adding and continue with the process.</p>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<div id="criteria">
    <ul id="sortable">
        <?php foreach($Criteria as $C) {?>
            <li id="criteria_<?php echo $C->criteria_id; ?>"><?php echo CHtml::encode($C->title); ?> <span><a href="<?php echo $this->createUrl('create', array('criteria_id' => $C->criteria_id)); ?>">edit</a> | <a href="<?php echo $this->createUrl('delete', array('criteria_id' => $C->criteria_id)); ?>">delete</a></span></li>
        <?php }?>
    </ul>
</div>