<?php if(!empty($eval)){ ?>
    <form id="evaluation" method="post" enctype="application/x-www-form-urlencoded">
        <?php $i = 0;?>
        <?php foreach($eval as $alternativeId => $Alternative){ ?>
            <div class="alternative<?php if($i % 2 == 0){ ?> first<?php } ?>">
                <h2><?php echo CHtml::encode($Alternative['Obj']->title); ?></h2>
                <ul>
                    <?php foreach($Alternative['Criteria'] as $criteriaId => $Criteria){ ?>
                        <li>
                            <label for="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>"><?php echo CHtml::encode($Criteria['Obj']->title); ?></label>
                            <div class="slider">
                                <p>
                                    <span><?php echo CHtml::encode($Criteria['Obj']->worst); ?></span>
                                    <select name="eval[<?php echo $alternativeId; ?>][<?php echo $criteriaId; ?>]" id="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>">
                                        <?php for($j = 1; $j <= 10; $j++){?>
                                            <option value="<?php echo $j;?>"<?php if($j == $Criteria['Evaluation']->grade){?> selected="selected"<?php }?>><?php echo $j;?></option>
                                        <?php }?>
                                    </select>
                                    <span class="right"><?php echo CHtml::encode($Criteria['Obj']->best); ?></span>
                                </p>
                            </div>
                        </li>
                    <?php }?>
                </ul>
            </div>
        <?php $i++; ?>
        <?php }?>
        <?php echo CHtml::submitButton('Save and continue'); ?>
    </form>
<?php } ?>