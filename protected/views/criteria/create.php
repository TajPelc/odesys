<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>

<div id="heading">
    <h2>What factors influence your decision the most?</h2>
    <a href="#">Help</a>
    <h3><?php echo CHtml::encode(Project::getActive()->title);?></h3>
</div>

<div id="content">
    <?php echo CHtml::beginForm('', 'post'); ?>
        <?php $Criteria = $Project->findCriteriaByPriority(); ?>
        <div><input type="text" name="newCriteria[title]" id="newCriteria" /></div>
        <ol>
        <?php for ($i = 0; $i < count($Criteria); $i++) { ?>
            <li>
                <input type="text" name="criteria[<?php echo $Criteria[$i]->criteria_id; ?>][title]" id="criteria_<?php echo $Criteria[$i]->criteria_id; ?>" value="<?php echo $Criteria[$i]->title; ?>" />
            </li>
        <?php } ?>
        </ol>
        <input type="submit" name="submit" value="Add" />
    <?php echo CHtml::endForm();?>
    <ul id="content-nav">
        <li class="prev"><?php echo CHtml::link('Previous', array('alternative/create')); ?></li>
        <li class="next<?php echo (!$Project->checkCriteriaComplete() ? ' disabled' : ''); ?>"><?php echo ($Project->checkCriteriaComplete() ? CHtml::link('Next', array('evaluation/evaluate')) : '<span>Next</span>'); ?></li>
    </ul>
</div>
<div id="sidebar"></div>