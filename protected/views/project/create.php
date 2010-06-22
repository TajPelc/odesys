<?php
$this->breadcrumbs=array(
    $model->isNewRecord ? 'Create project' : 'Edit project details',
    'Define criteria' => array('criteria/create'),
    'Define alternatives' => array('alternative/create'),
    'Evaluation' => array('evaluation/evaluate'),
    'Results' => array('results/display'),
);

$this->menu=array(
    array('label'=>'Project list', 'url'=>array('index')),
);
?>

<h1><?php if( $model->isNewRecord) { ?>Create Project<?php } else { ?>Project details<?php }?></h1>
<p><?php if( $model->isNewRecord) { ?>Create a project by filling the form to start the decision support process.<?php } else { ?>Modify values in the form to edit active project's details.<?php }?></p>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>