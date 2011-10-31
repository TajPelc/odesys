<?php if(!Ajax::isAjax()) { ?>
<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Evaluation'; ?>

<h2>How would you rate “<em><?php echo CHtml::encode($Criteria->title); ?></em>”?</h2>
<p>Think about how alternatives compare at this factor and adjust the sliders to the appropriate position.</p>

<div id="content">
    <form id="evaluation" method="post" enctype="application/x-www-form-urlencoded" action="">
<?php }?>
<?php if($renderEvaluation) { ?>
        <ul>
            <?php foreach($this->DecisionModel->alternatives as $Alternative) { ?>
            <?php $Evaluation = isset($eval[$Alternative->alternative_id]) ? $eval[$Alternative->alternative_id] : false; ?>
            <li<?php echo ((bool)$Evaluation ? ' class="saved"' : ''); ?>>
                <h3><b><?php echo CHtml::encode(Common::truncate($Alternative->title, 45))?></b></h3>
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
    <ul id="content-nav">
        <?php if($pageNr > 0) { ?>
        <?php $prev = CHtml::link('Previous<span class="doors">&nbsp;</span>', array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label, 'pageNr' => $pageNr - 1)); ?>
        <?php } else { ?>
        <?php $prev = CHtml::link('Previous<span class="doors">&nbsp;</span>', array('/decision/criteria', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label), array('class' => 'changePage')); ?>
        <?php }?>
        <?php if($pageNr < $nrOfCriteria - 1) { ?>
        <?php $next = CHtml::link('Next<span class="doors">&nbsp;</span>', array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label, 'pageNr' => $pageNr + 1)); ?>
        <?php } else { ?>
        <?php $next = CHtml::link('Next<span class="doors">&nbsp;</span>', array('/decision/analysis', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label), array('class' => 'changePage')); ?>
        <?php } ?>
        <li class="prev"><?php echo $prev; ?></li>
        <li class="next"><?php echo $next; ?></li>
    </ul>
</div>
<div id="sidebar">
    <ul class="steps">
<?php } ?>
<?php if ($renderSidebar) { ?>
        <?php $i = 0;?>
        <?php foreach($this->DecisionModel->findCriteriaByPriority() as $C) { ?>
            <?php $current = ($C->criteria_id == $Criteria->criteria_id);?>
            <?php $evaluated = $C->isDecisionEvaluated(); ?>
            <li<?php if($current || $evaluated) { echo ' class="'; if($current){echo 'current';} if($current && $evaluated){echo ' ';} if($evaluated){echo 'saved';} echo '"';}?>>
                <?php if($current) { ?><span>&nbsp;</span><?php }?>
                <?php if($evaluated) { ?>
                <?php echo CHtml::link(CHtml::encode(Common::truncate($C->title, ($current ? 28 : 30))), array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label, 'pageNr' => $i++)); ?>
                <?php } else { ?>
                <?php echo Common::truncate($C->title, ($current ? 28 : 32)); ?>
                <?php }?>
            </li>
        <?php } ?>
<?php } ?>
<?php if(!Ajax::isAjax()) { ?>
    </ul>
</div>
<?php } ?>
