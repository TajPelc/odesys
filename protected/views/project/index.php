<?php
$this->breadcrumbs=array(
    'Projects',
);

$this->menu=array(
    array('label'=>'Start a new project', 'url'=>array('create')),
);
?>

<h1>Projects</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
