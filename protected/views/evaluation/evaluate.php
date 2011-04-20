<?php if(!Ajax::isAjax()) { ?>
<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Evaluation'; ?>

<div id="heading">
    <h2>Move each slider to the appropriate position to evaluate alternatives.</h2>
    <a id="helpButton" href="#">Help</a>
    <h3><?php echo CHtml::encode(Project::getActive()->title);?></h3>
    <div id="help" style="display: none;">
        <h3>Need some help?</h3>
        <ul>
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
        <span class="helpClose">&nbsp;</span>
        <div id="helpEnd"></div>
    </div>
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
    <ul id="content-nav">
        <?php if($pageNr > 0) { ?>
        <?php $prev = CHtml::link('Previous', array('evaluation/evaluate', 'pageNr' => $pageNr - 1)); ?>
        <?php } else { ?>
        <?php $prev = CHtml::link('Previous', array('criteria/create'), array('class' => 'changePage')); ?>
        <?php }?>
        <?php if($pageNr < $nrOfCriteria - 1) { ?>
        <?php $next = CHtml::link('Next', array('evaluation/evaluate', 'pageNr' => $pageNr + 1)); ?>
        <?php } else { ?>
        <?php $next = CHtml::link('Next', array('analysis/display'), array('class' => 'changePage')); ?>
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
        <?php foreach($Project->findCriteriaByPriority() as $C) { ?>
            <?php $current = ($C->criteria_id == $Criteria->criteria_id);?>
            <?php $evaluated = $C->isDecisionEvaluated(); ?>
            <li<?php if($current || $evaluated) { echo ' class="'; if($current){echo 'current';} if($current && $evaluated){echo ' ';} if($evaluated){echo 'saved';} echo '"';}?>>
                <?php if($current) { ?><span>&nbsp;</span><?php }?>
                <?php if($evaluated) { ?>
                <?php echo CHtml::link(CHtml::encode(Common::truncate($C->title, ($current ? 28 : 32))), array('evaluation/evaluate', 'pageNr' => $i++)); ?>
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
