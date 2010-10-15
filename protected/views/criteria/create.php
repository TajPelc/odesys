<div id="content">
    <?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>
    <?php echo $this->renderPartial('_form', array('model' => $model, 'Project' => $Project)); ?>

    <?php echo Chtml::button('Add criteria', array('id' => 'create', 'class' => 'hidden')); ?>
    <?php $Criteria = $Project->findCriteriaByPriority(); ?>
    <div id="criteria">
        <?php if(Common::isArray($Criteria)) {?>
            <ul id="sortable">
                <?php foreach($Criteria as $C) {?>
                    <li id="criteria_<?php echo $C->criteria_id; ?>" class="movable"><span><?php echo CHtml::encode($C->title); ?></span><?php echo CHtml::link('delete', array('delete', 'criteria_id' => $C->criteria_id), array('class' => 'delete')); ?><?php echo CHtml::link('edit', array('create', 'criteria_id' => $C->criteria_id), array('class' => 'edit')); ?></li>
                <?php }?>
            </ul>
        <?php }?>
    </div>
    <?php echo CHtml::link('Continue', array('alternative/create'), array('class' => 'button right' . (count($Project->criteria) > 1 ? '' : ' hide'))); ?>
</div>
<div id="sidebar">
    <ul>
	    <li><em>Drag and drop the most important criteria to the top of the list.</em></li>
	    <li><p>Add between 2 and 10 criteria.</p></li>
	    <li><p>Criteria priority exponentially decends from top to bottom.</p></li>
	    <li><p>Think twice about most and least desired values.</p></li>
	    <li><p>Set the best and worst values low or high enough that no alternative that you are considering falls under or over this margin.</p></li>
    </ul>
</div>