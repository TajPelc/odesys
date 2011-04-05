<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Alternatives'; ?>
<div id="content">
    <h2>Enter alternatives between which you are choosing:</h2>
    <?php echo CHtml::beginForm('', 'post'); ?>
        <?php $Alternatives = $Project->alternatives; ?>
        <div><input type="text" name="newAlternative[title]" id="newAlternative" /></div>
        <ol>
        <?php for ($i = 0; $i < count($Alternatives); $i++) { ?>
                <li>
                    <input type="text" name="alternative[<?php echo $Alternatives[$i]->alternative_id; ?>][title]" id="alternative_<?php echo $Alternatives[$i]->alternative_id; ?>" value="<?php echo $Alternatives[$i]->title; ?>" />
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