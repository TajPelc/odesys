<?php
$this->breadcrumbs=array(
    'Projects'=>array('index'),
    $model->title,
);

$this->menu=array(
    array('label'=>'Edit project',              'url' => array('create',                'project_id' => $model->project_id)),
    array('label'=>'Define criteria',           'url' => array('criteria/create',       'project_id' => $model->project_id)),
    array('label'=>'Define alternatives',       'url' => array('alternative/create',    'project_id' => $model->project_id)),
    array('label'=>'Evaluation',                'url' => array('evaluation/evaluate',   'project_id' => $model->project_id)),
    array('label'=>'Results',                   'url' => array('results/display',       'project_id' => $model->project_id)),
    array('label'=>'Delete project',            'url' => '#', 'linkOptions' => array('submit' => array('delete', 'project_id' => $model->project_id), 'confirm' => 'Are you sure you want to delete this project? (cannot be undone)')),
);
?>

<h1><i><?php echo CHtml::encode($model->title); ?></i></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes'=>array(
        'description',
        'created',
    ),
)); ?>
<br />

<?php $crit = $model->criteria; ?>
<?php if(is_array($crit) && count($crit) > 0) { ?>
    <h2>Criteria</h2>
    <?php foreach($model->criteria as $Criteria) {?>
        <i><?php echo CHtml::encode($Criteria->title)?></i>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $Criteria,
            'attributes'=>array(
                'worst',
                'best',
                'description',
            ),
        )); ?>
        <br />
    <?php }?>
<?php }?>

<?php $alternatives = $model->alternatives; ?>
    <?php if(is_array($alternatives) && count($alternatives) > 0) { ?>
        <h2>Alternatives</h2>
        <?php foreach($model->alternatives as $Alternative) {?>
        <i><?php echo CHtml::encode($Alternative->title)?></i>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $Alternative,
            'attributes'=>array(
                'description',
            ),
        )); ?>
        <br />
    <?php }?>
<?php }?>