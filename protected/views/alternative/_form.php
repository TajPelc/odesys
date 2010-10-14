<?php if(Ajax::isAjax()) { ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'alternative-overlay-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <fieldset>
        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'title'); ?>
            <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>60)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>35)); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
    </fieldset>
<?php $this->endWidget(); ?>
<?php } else { ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'alternative-form',
    'enableAjaxValidation'=>false,
)); ?>
<fieldset>
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
        <?php if(count($Project->alternatives) > 1){ echo CHtml::link('Continue', array('evaluation/evaluate'), array('class' => 'button')); } ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php }?>