<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>
<div id="content">
    <h2>Enter criterias that are important for your decision:</h2>
    <?php echo CHtml::beginForm('', 'post'); ?>
        <?php $Criteria = $Project->criteria; ?>
        <div><input type="text" name="newCriteria[title]" id="newCriteria" /></div>
        <ol>
        <?php for ($i = 0; $i < count($Criteria); $i++) { ?>
                <li>
                    <input type="text" name="criteria[<?php echo $Criteria[$i]->criteria_id; ?>][title]" id="criteria_<?php echo $Criteria[$i]->criteria_id; ?>" value="<?php echo $Criteria[$i]->title; ?>" />
                </li>
        <?php } ?>
        </ol>
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
</div>