<?php if(!Ajax::isAjax()) { ?>
<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Evaluation'; ?>

<div id="heading">
    <h2>Move each slider to the appropriate position to evaluate alternatives.</h2>
    <a href="#">Help</a>
    <h3>Now deciding on "<?php echo CHtml::link(CHtml::encode(Project::getActive()->title), array('analysis/display'));?>"</h3>
</div>

<div id="content">
    <form id="evaluation" method="post" enctype="application/x-www-form-urlencoded" action="">
<?php }?>
<?php if($renderEvaluation) { ?>
        <ul>
            <?php foreach($Project->alternatives as $Alternative) { ?>
            <?php $Evaluation = isset($eval[$Alternative->alternative_id]) ? $eval[$Alternative->alternative_id] : false; ?>
            <li<?php echo ((bool)$Evaluation ? ' class="saved"' : ''); ?>>
                <h3><b><?php echo CHtml::encode(Common::truncate($Criteria->title, 45))?></b> <em>for</em> <b><?php echo CHtml::encode(Common::truncate($Alternative->title, 45))?></b> <em>is</em></h3>
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
    <?php }?>
    <?php if(!Ajax::isAjax()) { ?>
    </form>
    <ul>
        <li><?php echo ( $pageNr > 0 ? CHtml::link('Previous', array('evaluation/evaluate', 'pageNr' => $pageNr - 1), array('class' => 'previous')) : '')?></li>
        <li>Criteria <?php echo $pageNr + 1; ?> of <?php echo $nrOfCriteria ?></li>
        <li><?php echo ( $pageNr < $nrOfCriteria - 1 ? CHtml::link('Next', array('evaluation/evaluate', 'pageNr' => $pageNr + 1), array('class' => 'next')) : '')?></li>
    </ul>
</div>
<div id="sidebar">
    <h3>Evaluation steps</h3>
    <ul class="steps">
<?php } ?>
<?php if ($renderSidebar) { ?>
        <?php $i = 0;?>
        <?php foreach($Project->findCriteriaByPriority() as $C) { ?>
            <?php $current = ($C->criteria_id == $Criteria->criteria_id);?>
            <?php $evaluated = $C->isDecisionEvaluated(); ?>
            <li<?php if($current || $evaluated) { echo ' class="'; if($current){echo 'current';} if($current && $evaluated){echo ' ';} if($evaluated){echo 'saved';} echo '"';}?>>
                <?php if($current) { ?><span>&nbsp;</span><?php }?>
                <?php echo CHtml::link(CHtml::encode(Common::truncate($C->title, ($current ? 28 : 32))), array('evaluation/evaluate', 'pageNr' => $i++)); ?>
            </li>
        <?php } ?>
<?php } ?>
<?php if(!Ajax::isAjax()) { ?>
    </ul>
    <ul class="help">
        <li>
            <dl>
                <dt>Think</dt>
                <dd>Read the sentances and think about how each alternative compares at a given criteria. If a sentance doesn't make any sense, you should probably rename your criteria or alternatives.</dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>How to evaluate</dt>
                <dd>Just move or click on the slider to evaluate an alternative.</dd>
            </dl>
        </li>
    </ul>
</div>
<?php } ?>