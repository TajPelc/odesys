<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>
<div id="content">
<?php CHtml::beginForm('', 'post', array('id' => 'criteria')); ?>
    <?php foreach ($Project->criteria as $C) { ?>
        <?php // echo $form->labelEx($model,'title', array('label' => 'Criteria name', 'for' => 'c_'.$C->criteria_id)); ?>
        <?php // echo $form->textField($model,'title', array('size'=>60,'maxlength'=>60, 'value' => $C->title, 'id' => 'c_'.$C->criteria_id)); ?>
    <?php } ?>
<?php CHtml::endForm();?>
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