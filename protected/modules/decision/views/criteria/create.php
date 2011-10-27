<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Criteria'; ?>

<div id="heading">
    <h2>What factors influence your decision the most?</h2>
    <a id="helpButton" href="#">Help</a>
    <?php if($this->Decision->isPublished()){ ?><h3><?php echo CHtml::link('Back to report<span>&nbsp;</span>', CHtml::encode($this->publicLink)); ?></h3><?php } ?>
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
                    <dt>Random Examples</dt>
                    <dd>Speed, Length, Looks, Location, Performance, Price, Education, Safety, Running costs</dd>
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
    <h2>What factors influence your decision the most?</h2>
    <p>When choosing which car to buy, some sample factors would be Acceleration, Top speed, Safety, and so on. Think of some factors that apply to your decision and order them by priority from the most important to the least imporatnt.</p>
    <?php echo CHtml::beginForm('', 'post'); ?>
        <?php $Criteria = $this->DecisionModel->findCriteriaByPriority(); ?>
        <div><input type="text" name="newCriteria[title]" id="newCriteria" /></div>
        <ol>
        <?php for ($i = 0; $i < count($Criteria); $i++) { ?>
            <li class="drag">
                <input type="text" name="criteria[<?php echo $Criteria[$i]->criteria_id; ?>][title]" id="criteria_<?php echo $Criteria[$i]->criteria_id; ?>" value="<?php echo $Criteria[$i]->title; ?>" />
            </li>
        <?php } ?>
        </ol>
        <input type="submit" name="submit" value="Add" />
    <?php echo CHtml::endForm();?>
    <ul id="content-nav">
        <li class="prev"><?php echo CHtml::link('Previous<span class="doors">&nbsp;</span>', array('/decision/alternatives', 'decisionId' => $this->Decision->decision_id, 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)); ?></li>
        <li class="next<?php echo (!$this->DecisionModel->checkCriteriaComplete() ? ' disabled' : ''); ?>"><?php echo ($this->DecisionModel->checkCriteriaComplete() ? CHtml::link('Next<span class="doors">&nbsp;</span>', array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)) : '<span>Next<span class="doors">&nbsp;</span></span>'); ?></li>
    </ul>
</div>
<div id="sidebar" class="help">
    <h4>What are criteria?</h4>
    <p>Criteria are factors that influence your decision.</p>
    <p>When buying a car, one may choose Speed, Performance, Price, Safety and so on as the criteria.</p>
    <p>You may order criteria by priority (descending).</p>
    <p class="l">In the next step, each alternative is going to be evaluated by each criteria.</p>
    <div class="last"></div>
</div>