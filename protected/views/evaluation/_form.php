<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'evaluation-form',
    'enableAjaxValidation'=>false,
)); ?>

<?php foreach($eval as $alternativeId => $Alternative){ ?>
    <fieldset>
        <legend><?php echo CHtml::encode($Alternative['Obj']->title); ?></legend>

        <?php foreach($Alternative['Criteria'] as $criteriaId => $Criteria){ ?>
            <div class="row">
                <label for="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>"><?php echo CHtml::encode($Criteria['Obj']->title); ?></label>
                <select name="eval[<?php echo $alternativeId; ?>][<?php echo $criteriaId; ?>]" id="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>">
                    <?php for($i = 1; $i <= 10; $i++){?>
                        <option value="<?php echo $i;?>"<?php if($i == $Criteria['Evaluation']->grade){?> selected="selected"<?php }?>><?php echo $i;?></option>
                    <?php }?>
                </select>
                <?php echo CHtml::encode($Criteria['Obj']->worst); ?> (1) -
                <?php echo CHtml::encode($Criteria['Obj']->best); ?> (10)
            </div>
            <?php }?>
    </fieldset>
<?php }?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Save and show results'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->