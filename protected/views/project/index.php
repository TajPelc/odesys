<?php $this->pageTitle = Yii::app()->name . ' / ' . ' My Projects'; ?>
<h1>My Projects</h1>
<?php if(!empty($Projects)) { ?>
<p>Click on an existing project to make it active (appear in the left sidebar).</p>
<ul class="projects">
    <?php foreach($Projects as $P) {?>
        <?php $active = (false !== $Project && $P->project_id === $Project->project_id);?>
        <?php $Alternatives = $P->alternatives; ?>
        <li<?php if($active) { ?> class="active"<?php }?>>
            <?php if($active) { ?>
                <span><?php echo CHtml::encode($P->title)?></span>
                <?php echo CHtml::link(CHtml::encode($P->title), array('view', 'project_id' => $P->project_id), array('style' => 'display: none;', 'title' => CHtml::encode($P->title))); ?>
            <?php } else { ?>
                <?php echo CHtml::link(CHtml::encode($P->title), array('view', 'project_id' => $P->project_id), array('title' => CHtml::encode($P->title))); ?>
            <?php }?>
            <?php if(empty($Alternatives)){ ?>
                <p>No alternatives defined</p>
            <?php } else { ?>
                <ul>
                    <?php foreach($Alternatives as $A) {?>
                        <li><?php echo CHtml::encode($A->title);?></li>
                    <?php }?>
                </ul>
            <?php }?>
        </li>
    <?php }?>
</ul>
<?php }?>
<p><?php echo CHtml::link('Create a new project', array('create', 'createNew' => '1'), array('class' => 'button')); ?></p>