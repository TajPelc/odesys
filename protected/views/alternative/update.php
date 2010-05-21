<?php
$this->breadcrumbs=array(
	'Alternatives'=>array('index'),
	$model->title=>array('view','id'=>$model->alternative_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Alternative', 'url'=>array('index')),
	array('label'=>'Create Alternative', 'url'=>array('create')),
	array('label'=>'View Alternative', 'url'=>array('view', 'id'=>$model->alternative_id)),
	array('label'=>'Manage Alternative', 'url'=>array('admin')),
);
?>

<h1>Update Alternative <?php echo $model->alternative_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>