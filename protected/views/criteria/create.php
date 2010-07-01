<h1>Criteria</h1>
<p>Add between 2 and 10 criteria for rating the alternatives. Provide best and worst case scenario values. Set the best and worst values low or high enough that no alternative that you are considering falls under or over this marign. (Example: Price range / High - 600€ / Low 350€)</p>
<?php echo $this->renderPartial('_form', array('model' => $model, 'Project' => $Project)); ?>

<?php $Criteria = $Project->findCriteriaByPriority(); ?>
<h2>Criteria</h2>
<p>You may drag each criteria up or down to rearrange the list by priority. The most important criteria to you is at the top. Criteria of lowest importance at the bottom.</p>
<?php  echo CHtml::link('Add criteria', array('#'), array('title' => 'Add criteria', 'id' => 'create-criteria', 'class' => 'button hidden')); ?>
<div id="criteria">
    <?php if(Common::isArray($Criteria)) {?>
        <ul id="sortable">
            <?php foreach($Criteria as $C) {?>
                <li id="criteria_<?php echo $C->criteria_id; ?>" class="movable"><span>&uarr;&darr; <?php echo CHtml::encode($C->title); ?></span><?php echo CHtml::link('delete', array('delete', 'criteria_id' => $C->criteria_id), array('class' => 'delete')); ?><?php echo CHtml::link('edit', array('create', 'criteria_id' => $C->criteria_id), array('class' => 'edit')); ?></li>
            <?php }?>
        </ul>
    <?php }?>
</div>
<?php echo CHtml::link('Continue', array('alternative/create'), array('class' => 'button right' . (count($Project->criteria) > 1 ? '' : ' hide'))); ?>