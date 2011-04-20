<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Criteria'; ?>

<div id="heading">
    <h2>What factors influence your decision the most?</h2>
    <a id="helpButton" href="#">Help</a>
    <h3><?php echo CHtml::encode(Project::getActive()->title);?></h3>
    <div id="help" style="display: none;">
        <h3>Need some help?</h3>
        <ul>
            <li>
                <dl>
                    <dt>Think</dt>
                    <dd>What criteria must an alternative satisfy? What are important parameters of my alternatives?</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>Examples</dt>
                    <dd>When buying a car, it may be judged by it's Speed, Performance, Price, Safety, Running costs and so on.</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>Drag and drop</dt>
                    <dd>Criteria priority decends from top to bottom. Add some items to the list then move each criteria to the proper position by dragging it by the cross on the left. For example, if price is the most important factor, drag and drop it to the top of the list.</dd>
                </dl>
            </li>
        </ul>
        <div id="helpEnd"></div>
    </div>
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