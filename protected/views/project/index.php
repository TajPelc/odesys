<?php
$this->breadcrumbs=array(
    'Projects',
);

$this->menu=array(
    array('label'=>'Start a new project', 'url'=>array('create')),
);
?>

<h1>My Projects</h1>
<?php if(!empty($Projects)) { ?>
<p>Click on an existing project to make it active (appear in the left sidebar).</p>
<ul class="projects">
    <?php foreach($Projects as $P) {?>
        <li>
            <?php if(false !== $Project && $P->project_id === $Project->project_id) { ?>
                <span><?php echo CHtml::encode($P->title)?> (Active)</span><?php echo CHtml::link(CHtml::encode($P->title), array('view', 'project_id' => $P->project_id), array('style' => 'display: none;')); ?>
            <?php } else { ?>
                <?php echo CHtml::link(CHtml::encode($P->title), array('view', 'project_id' => $P->project_id)); ?>
            <?php }?>
        </li>
    <?php }?>
</ul>
<?php }?>
<p><?php echo CHtml::link('Create a new project', array('create', 'createNew' => '1'), array('class' => 'button')); ?></p>