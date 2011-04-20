<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Alternatives'; ?>

<div id="heading">
    <h2>What alternatives are you considering?</h2>
    <a id="helpButton" href="#"<?php if(User::current()->getConfig('help')) { echo ' class="active"'; }?>>Help</a>
    <h3><?php echo CHtml::encode(Project::getActive()->title);?></h3>
    <div id="help"<?php if(!User::current()->getConfig('help')) { ?> style="display: none;"<?php } else { ?> class="shown"<?php } ?>>
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
                    <dt>Examples</dt>
                    <dd>When choosing a career path one might create such a list of alternatives: Dentist, Physicist, Web application developer.</dd>
                </dl>
            </li>
        </ul>
        <span class="helpClose">&nbsp;</span>
        <div id="helpEnd"></div>
    </div>
</div>

<div id="content">
    <?php echo CHtml::beginForm('', 'post'); ?>
        <?php $Alternatives = $Project->alternatives; ?>
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
        <li class="next<?php echo (!$Project->checkAlternativesComplete() ? ' disabled' : ''); ?>"><?php echo ($Project->checkAlternativesComplete() ? CHtml::link('Next', array('criteria/create')) : '<span>Next</span>'); ?></li>
    </ul>
</div>
<div id="sidebar"></div>