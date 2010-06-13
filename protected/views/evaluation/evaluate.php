<?php
$this->breadcrumbs=array(
    'Edit project details'  => array('project/create', 'project_id' => $Project->project_id),
    'Define criteria'       => array('criteria/create'),
    'Define alternatives'   => array('alternative/create'),
    'Evaluation',
    'Results' => array('results/display'),
);
?>

<h1>Evaluation</h1>

<?php echo $this->renderPartial('_form', array('eval' => $eval)); ?>