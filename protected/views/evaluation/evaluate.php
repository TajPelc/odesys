<?php
$this->breadcrumbs=array(
    $Project->title => array('project/create', 'id' => $Project->project_id),
    'Define criteria' => array('criteria/create'),
    'Define alternatives' => array('alternative/create'),
    'Evaluation',
);
?>

<h1>Evaluation</h1>

<?php echo $this->renderPartial('_form', array('eval' => $eval)); ?>