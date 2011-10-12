<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Alternatives'; ?>

<div id="heading">
    <h2>What alternatives are you considering?</h2>
    <a id="helpButton" href="#">Help</a>
    <h3><?php echo CHtml::link(CHtml::encode($this->Decision->title), $this->publicLink); ?></h3>
    <div id="help" style="display: none;">
        <h3>Need some help?</h3>
        <ul>
            <li>
                <dl>
                    <dt>Think</dt>
                    <dd>Have you thought of all possible alternatives? Your decision will be complete by choosing one of these alternatives. What are you considering?</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>Random Examples</dt>
                    <dd>Family car, Apartment in the city, Dentist, Physicist, Web application developer, Ice cream</dd>
                </dl>
            </li>
        </ul>
        <span class="helpClose">&nbsp;</span>
        <div id="helpEnd"></div>
    </div>
</div>

<div id="content">
    <?php echo CHtml::beginForm('', 'post'); ?>
        <?php $Alternatives = $this->DecisionModel->alternatives; ?>
        <div><input type="text" name="newAlternative[title]" id="newAlternative" /></div>
        <ol>
        <?php for ($i = 0; $i < count($Alternatives); $i++) { ?>
                <li>
                    <input type="text" name="alternative[<?php echo $Alternatives[$i]->alternative_id; ?>][title]" id="alternative_<?php echo $Alternatives[$i]->alternative_id; ?>" value="<?php echo $Alternatives[$i]->title; ?>" />
                </li>
        <?php } ?>
        </ol>
        <input type="submit" name="submit" value="Add" />
    <?php echo CHtml::endForm();?>
    <ul id="content-nav">
        <li class="next<?php echo (!$this->DecisionModel->checkAlternativesComplete() ? ' disabled' : ''); ?>"><?php echo ($this->DecisionModel->checkAlternativesComplete() ? CHtml::link('Next<span class="doors">&nbsp;</span>', array('/decision/criteria', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)) : '<span>Next<span class="doors">&nbsp;</span></span>'); ?></li>
    </ul>
</div>
<div id="sidebar" class="help">
    <h4>What are alternatives?</h4>
    <p>Alternatives are the subject of your decision. An alternative is one of a number of things from which usually only one can be chosen.</p>
    <p class="l">When choosing a career path one might create such a list of alternatives: Dentist, Physicist, Web application developer.</p>
    <div class="last"></div>
</div>