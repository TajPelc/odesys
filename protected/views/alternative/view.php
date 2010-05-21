<?php
$this->breadcrumbs=array(
	'Alternatives'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Alternative', 'url'=>array('index')),
	array('label'=>'Create Alternative', 'url'=>array('create')),
	array('label'=>'Update Alternative', 'url'=>array('update', 'id'=>$model->alternative_id)),
	array('label'=>'Delete Alternative', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->alternative_id),'confirm'=>'Are you sure to delete this item?')),
	array('label'=>'Manage Alternative', 'url'=>array('admin')),
);
?>

<h1>View Alternative #<?php echo $model->alternative_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'alternative_id',
		'rel_project_id',
		'title',
		'description',
	),
)); ?>
