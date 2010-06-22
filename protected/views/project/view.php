<?php
$this->breadcrumbs=array(
    'Projects'=>array('index'),
    $model->title,
);

$this->menu=array(
    array('label'=>'Make active', 'url' => array('view', 'make_active' => $model->project_id)),
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