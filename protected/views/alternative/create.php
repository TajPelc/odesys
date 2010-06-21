<?php
$this->breadcrumbs=array(
    'Edit project details' => array('project/create', 'id' => $Project->project_id),
    'Define criteria' => array('criteria/create'),
    'Define alternatives',
    'Evaluation' => array('evaluation/evaluate'),
    'Results' => array('results/display'),
);
?>
<h1>Define alternatives</h1>
<p>Add alternatives for evaluation. Minimum of 2 required. In the next step you will evaluate each alternative added here by the criteria you defined earlier.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<h2>Alternatives</h2>
<p>You may not change the order of criteria.</p>
<div id="criteria">
    <?php $Alternatives = $Project->alternatives; ?>
    <?php if(Common::isArray($Alternatives)) {?>
        <ul id="sortable">
            <?php foreach($Alternatives as $A) {?>
                <li id="alternative_<?php echo $A->alternative_id; ?>"><span><?php echo CHtml::encode($A->title); ?></span><a href="<?php echo $this->createUrl('delete', array('alternative_id' => $A->alternative_id)); ?>">delete</a><a href="<?php echo $this->createUrl('create', array('alternative_id' => $A->alternative_id)); ?>">edit</a></li>
            <?php }?>
        </ul>
    <?php } else { ?>
        <p class="notice">No alternatives yet defined.</p>
    <?php }?>
</div>