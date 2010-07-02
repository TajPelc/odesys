<?php if(Ajax::isAjax()) { ?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'criteria-overlay-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <fieldset>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

            <div class="row">
                <?php echo $form->labelEx($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>60, 'class' => 'text ui-widget-content ui-corner-all')); ?>
                <?php // echo $form->error($model,'title'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'worst'); ?>
                <?php echo $form->textField($model,'worst',array('size'=>30,'maxlength'=>30, 'class' => 'text ui-widget-content ui-corner-all')); ?>
                <?php // echo $form->error($model,'worst'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model,'best'); ?>
                <?php echo $form->textField($model,'best',array('size'=>30,'maxlength'=>30, 'class' => 'text ui-widget-content ui-corner-all')); ?>
                <?php // echo $form->error($model,'best'); ?>
            </div>
            <div class="row">
                <?php echo $form->labelEx($model,'description'); ?>
                <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>35, 'class' => 'text ui-widget-content ui-corner-all')); ?>
                <?php // echo $form->error($model,'description'); ?>
            </div>
    </fieldset>
    <?php $this->endWidget(); ?>
<?php } else { ?>
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'criteria-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <fieldset>
        <div class="slideable">
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
            </div>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    </div><!-- form -->
<?php }?>