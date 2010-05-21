<?php
$this->breadcrumbs=array(
	'Criterias'=>array('index'),
	$model->title=>array('view','id'=>$model->criteria_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Criteria', 'url'=>array('index')),
	array('label'=>'Create Criteria', 'url'=>array('create')),
	array('label'=>'View Criteria', 'url'=>array('view', 'id'=>$model->criteria_id)),
	array('label'=>'Manage Criteria', 'url'=>array('admin')),
);
?>

<h1>Update Criteria <?php echo $model->criteria_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>