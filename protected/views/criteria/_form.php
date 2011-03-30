<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'criteria-form',
    'enableAjaxValidation' => false,
)); ?>
        <?php echo $form->errorSummary($model); ?>

        <?php foreach ($Project->criteria as $C) {?>
        <?php echo $form->labelEx($model,'title', array('label' => 'Criteria name', 'for' => 'c_'.$C->criteria_id)); ?>
        <?php echo $form->textField($model,'title', array('size'=>60,'maxlength'=>60, 'value' => $C->title, 'id' => 'c_'.$C->criteria_id)); ?>
        <?php } ?>

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
<?php $this->endWidget(); ?>