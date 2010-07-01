<h1>Alternatives</h1>
<p>Add alternatives for evaluation. Minimum of 2 required. In the next step you will evaluate each alternative added here by the criteria you defined earlier.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'Project' => $Project)); ?>

<h2>Alternatives</h2>
<p>You may not change the order of criteria.</p>
<div id="criteria">
    <?php $Alternatives = $Project->alternatives; ?>
    <ul id="sortable">
        <?php if(Common::isArray($Alternatives)) {?>
            <?php foreach($Alternatives as $A) {?>
                <li id="alternative_<?php echo $A->alternative_id; ?>"><span>&times; <?php echo CHtml::encode($A->title); ?></span><a href="<?php echo $this->createUrl('delete', array('alternative_id' => $A->alternative_id)); ?>">delete</a><a href="<?php echo $this->createUrl('create', array('alternative_id' => $A->alternative_id)); ?>">edit</a></li>
            <?php }?>
        <?php } else { ?>
            <li><span>No alternatives yet defined.</span></li>
        <?php }?>
    </ul>
</div>