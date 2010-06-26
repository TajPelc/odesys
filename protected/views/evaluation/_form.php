<?php if(!empty($eval)){ ?>
    <form id="evaluation" method="post" enctype="application/x-www-form-urlencoded">
        <?php foreach($eval as $alternativeId => $Alternative){ ?>
            <div class="alternative">
                <h2><?php echo CHtml::encode($Alternative['Obj']->title); ?></h2>

                <ul>
                    <?php foreach($Alternative['Criteria'] as $criteriaId => $Criteria){ ?>
                        <li>
                            <label for="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>"><?php echo CHtml::encode($Criteria['Obj']->title); ?></label>
                            <div class="slider">
                                <p>
                                    <span><?php echo CHtml::encode($Criteria['Obj']->worst); ?></span>
                                    <select name="eval[<?php echo $alternativeId; ?>][<?php echo $criteriaId; ?>]" id="eval<?php echo $alternativeId; ?>-<?php echo $criteriaId; ?>">
                                        <?php for($i = 1; $i <= 10; $i++){?>
                                            <option value="<?php echo $i;?>"<?php if($i == $Criteria['Evaluation']->grade){?> selected="selected"<?php }?>><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
                                    <span class="right"><?php echo CHtml::encode($Criteria['Obj']->best); ?></span>
                                </p>
                            </div>
                        </li>
                    <?php }?>
                </ul>
            </div>
        <?php }?>
        <?php echo CHtml::submitButton('Save and continue'); ?>
    </form>
<?php } ?>