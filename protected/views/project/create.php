<?php
$this->breadcrumbs=array(
    $model->isNewRecord ? 'Create Project' : CHtml::encode($model->title),
);

$this->menu=array(
    array('label'=>'Project list', 'url'=>array('index')),
);
?>

<h1><?php if( $model->isNewRecord) { ?>Create Project<?php } else { echo CHtml::encode($model->title); }?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>