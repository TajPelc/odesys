<?php if(!empty($eval)){ ?>
    <form id="evaluation" method="post" enctype="application/x-www-form-urlencoded">
    <?php if('criteria' != $sortType) { ?>
    <?php $i = 0;?>
        <?php foreach($eval as $alternativeId => $Alternative){ ?>
            <div class="alternative<?php if($i % 2 == 0){ ?> first<?php } ?>">
                <p>Alternative <span class="number">#<?php echo $i+1;?></span></p>
                <h2><?php echo CHtml::encode($Alternative['Obj']->title); ?></h2>
                <ul>
                    <?php foreach($Alternative['Criteria'] as $criteriaId => $Criteria){ ?>
                        <li>
                            <label for="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>"><?php echo CHtml::encode($Criteria['Obj']->title); ?></label>
                            <div class="slider">
                                <p>
                                    <span><?php echo CHtml::encode($Criteria['Obj']->worst); ?></span>
                                    <select name="eval[<?php echo $alternativeId; ?>][<?php echo $criteriaId; ?>]" id="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>">
                                        <?php for($j = 0; $j <= 10; $j++){?>
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
    <?php } else { ?>
        <?php $i = 0;?>
        <?php foreach($eval as $criteriaId => $Criteria){ ?>
            <div class="alternative<?php if($i % 2 == 0){ ?> first<?php } ?>">
                <p>Criteria <span class="number">#<?php echo $i+1;?></span></p>
                <h2><?php echo CHtml::encode($Criteria['Obj']->title); ?></h2>
                <ul>
                    <?php foreach($Criteria['Alternatives'] as $alternativeId => $Alternative){ ?>
                        <li>
                            <label for="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>"><?php echo CHtml::encode($Alternative['Obj']->title); ?></label>
                            <div class="slider">
                                <p>
                                    <span><?php echo CHtml::encode($Criteria['Obj']->worst); ?></span>
                                    <select name="eval[<?php echo $alternativeId; ?>][<?php echo $criteriaId; ?>]" id="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>">
                                        <?php for($j = 0; $j <= 10; $j++){?>
                                            <option value="<?php echo $j;?>"<?php if($j == $Alternative['Evaluation']->grade){?> selected="selected"<?php }?>><?php echo $j;?></option>
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
    <?php }?>
    <?php echo CHtml::submitButton('Save'); ?>
    </form>
<?php } ?>