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
    <?php echo CHtml::endForm();?>
    <ul id="content-nav">
        <li class="prev"></li>
        <li class="next"><?php echo CHtml::link('Next', array('criteria/create')); ?></li>
    </ul>
</div>
<div id="sidebar"></div>