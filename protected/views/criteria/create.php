<div id="content">
    <?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>
    <?php echo $this->renderPartial('_form', array('model' => $model, 'Project' => $Project)); ?>
    
    <p>You may drag each criteria up or down to rearrange the list by priority. The most important criteria to you is at the top. Criteria of lowest importance at the bottom.</p>
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
    <p>Add between 2 and 10 criteria for rating the alternatives. Provide best (most desired) and worst (least desired) values. Set the best and worst values low or high enough that no alternative that you are considering falls under or over this marign.</p>
    <p>Sample criteria: Max speed / <em>Worst:</em> 140kph / <em>Best:</em> 220kph, Price / <em>Worst:</em> 25.000€ / <em>Best:</em> 10.000€</p>
</div>