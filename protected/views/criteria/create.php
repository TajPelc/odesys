<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>
<div id="content">
    <?php echo CHtml::beginForm('', 'post', array('id' => 'criteria')); ?>
        <?php $Criteria = $Project->criteria; ?>
        <?php for ($i = 0; $i < count($Criteria); $i++) { ?>
            <label for="criteria_<?php echo $Criteria[$i]->criteria_id; ?>"><?php echo $i+1;?></label>
            <input type="text" name="criteria[<?php echo $Criteria[$i]->criteria_id; ?>][title]" id="criteria_<?php echo $Criteria[$i]->criteria_id; ?>" value="<?php echo $Criteria[$i]->title; ?>" />
        <?php } ?>
        <label for="newCriteria">+</label>
    	<input type="text" name="newCriteria[title]" id="newCriteria" />
        <input type="submit" name="submit" value="Add" />
    <?php echo CHtml::endForm();?>
</div>
<div id="sidebar">
    <ul>
        <li><em>Drag and drop the most important criteria to the top of the list.</em></li>
        <li><p>Add between 2 and 10 criteria.</p></li>
        <li><p>Criteria priority exponentially decends from top to bottom.</p></li>
        <li><p>Think twice about most and least desired values.</p></li>
        <li><p>Set the best and worst values low or high enough that no alternative that you are considering falls under or over this margin.</p></li>
    </ul>
    <span>&nbsp;</span>
</div>