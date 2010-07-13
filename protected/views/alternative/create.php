<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Alternatives'; ?>
<h1>Alternatives</h1>
<p>Add alternatives for evaluation. Minimum of 2 required, maximum of 10 alternatives. In the next step you will evaluate each alternative added here by the criteria you defined earlier.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'Project' => $Project)); ?>

<p>You may not change the order of criteria.</p>
<?php echo Chtml::button('Add alternative', array('id' => 'create', 'class' => 'hidden')); ?>
<div id="alternative">
    <?php $Alternatives = $Project->alternatives; ?>
    <ul id="sortable">
        <?php if(Common::isArray($Alternatives)) {?>
            <?php foreach($Alternatives as $A) {?>
                <li id="alternative_<?php echo $A->alternative_id; ?>"><span><?php echo CHtml::encode($A->title); ?></span><?php echo CHtml::link('delete', array('delete', 'alternative_id' => $A->alternative_id), array('class' => 'delete')); ?><?php echo CHtml::link('edit', array('create', 'alternative_id' => $A->alternative_id), array('class' => 'edit')); ?></li>
            <?php }?>
        <?php }?>
    </ul>
</div>
<?php echo CHtml::link('Continue', array('evaluation/evaluate'), array('class' => 'button right' . (count($Project->alternatives) > 1 ? '' : ' hide'))); ?>