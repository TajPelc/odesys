<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Criteria'; ?>

<section class="content">
    <div id="content">
        <h1>What factors influence your decision the most?</h1>
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
            <li class="prev"><?php echo CHtml::link('Previous', array('/decision/alternatives', 'decisionId' => $this->Decision->decision_id, 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)); ?></li>
            <li class="next<?php echo (!$this->DecisionModel->checkCriteriaComplete() ? ' disabled' : ''); ?>"><?php echo ($this->DecisionModel->checkCriteriaComplete() ? CHtml::link('Next', array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)) : 'Next'); ?></li>
        </ul>
    </div>
    <div id="sidebar">
        <h2>What are factors?</h2>
        <p>Factors or criteria influence your decision.</p>
        <p>You may order factors by relavance (descending).</p>
        <p class="l">In the next step, each alternative is going to be evaluated by each factor.</p>
        <div class="last"></div>
    </div>
</section>
