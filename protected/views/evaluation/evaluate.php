<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Evaluation'; ?>
<div id="content">
    <p>Fill out the statements by moving the sliders to the appropriate location.</p>

    <h2><b><?php echo CHtml::encode($Criteria->title); ?></b> for</h2>
    <div>
        <form id="evaluation" method="post" enctype="application/x-www-form-urlencoded">
            <ul>
                <?php foreach($Project->alternatives as $Alternative) { ?>
                <?php $Evaluation = isset($eval[$Alternative->alternative_id]) ? $eval[$Alternative->alternative_id] : false; ?>
                <li<?php echo ((bool)$Evaluation ? ' class="saved"' : ''); ?>>
                    <h3><b><?php echo CHtml::encode($Alternative->title)?></b> is</h3>
                    <div>
                        <span class="worst">the worst</span>
                        <select id="<?php echo 'eval-'. $Alternative->alternative_id . '-' . $Criteria->criteria_id; ?>" name="<?php echo 'eval['. $Alternative->alternative_id . '][' . $Criteria->criteria_id . ']'; ?>">
                        <?php for($i = 0; $i <= 100; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo (((bool)$Evaluation && $Evaluation->grade == $i) ? 'selected="selected"' : ''); ?>><?php echo $i; ?></option>
                        <?php }?>
                        </select>
                        <span class="best">the best</span>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </form>
    </div>
    <ul>
        <li><a class="previous" href="#">Previous</a></li>
        <li>Criteria 5 of 9</li>
        <li><a class="next" href="#">Next</a></li>
    </ul>
</div>