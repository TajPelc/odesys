<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'criteria-form',
    'enableAjaxValidation'=>false,
)); ?>
<fieldset>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>85)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'worst'); ?>
        <?php echo $form->textField($model,'worst',array('size'=>60,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'worst'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'best'); ?>
        <?php echo $form->textField($model,'best',array('size'=>60,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'best'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
        <?php if(count($Project->criteria) > 1){ echo CHtml::link('Continue', array('alternative/create'), array('class' => 'button')); } ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->