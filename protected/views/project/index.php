<?php
$this->breadcrumbs=array(
    'Projects',
);

$this->menu=array(
    array('label'=>'Start a new project', 'url'=>array('create')),
);
?>

<h1>Projects</h1>
<ul class="projects">
    <?php foreach($Projects as $P) {?>
        <li><?php echo CHtml::link(CHtml::encode($P->title), array('view', 'project_id' => $P->project_id)); ?></li>
    <?php }?>
</ul>