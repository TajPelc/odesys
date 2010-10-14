<div id="project-overlay-form" class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'project-form',
    'enableAjaxValidation'=>false,
)); ?>
<fieldset>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title', array('label' => 'Project name')); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>200, 'class' => 'ui-corner-all')); ?>
        <?php //echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description', array('label' => 'Description')); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'class' => 'ui-corner-all')); ?>
        <?php //echo $form->error($model,'description'); ?>
    </div>

    <?php if(!Ajax::isAjax()) { ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create and continue' : 'Save and continue', array('class' => 'right')); ?>
    </div>
    <?php }?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
</fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->