<div id="content">
    <?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Alternatives'; ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model, 'Project' => $Project)); ?>

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
</div>
<div id="sidebar">
    <ul>
        <li><p><em>You may not change the order of alternatives.</em></p></li>
        <li><p>Consider all possible alternatives.</p></li>
        <li><p>Add a minimum of 2 alternatives, but no more than 10.</p></li>
        <li><p>On the next step you will evaluate each alternative by the criteria you defined.</p></li>
    </ul>
    <span>&npsp;</span>
</div>