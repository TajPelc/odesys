<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Alternatives'; ?>

<div id="heading">
    <h2>What alternatives are you considering?</h2>
    <a href="#">Help</a>
    <h3>Now deciding on "<?php echo CHtml::link(CHtml::encode(Project::getActive()->title), array('analysis/display'));?>"</h3>
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
        <ul id="content-nav">
            <li class="prev"></li>
            <li class="next"><?php echo CHtml::link('Next', array('criteria/create'), array('class' => 'next')); ?></li>
        </ul>
    <?php echo CHtml::endForm();?>
</div>
<div id="sidebar">
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
</div>