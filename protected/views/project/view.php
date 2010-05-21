<?php
$this->breadcrumbs=array(
    'Projects'=>array('index'),
    $model->title,
);

$this->menu=array(
    array('label'=>'Project list',              'url'=>array('index')),
    array('label'=>'Edit Project',              'url'=>array('create',      'project_id' => $model->project_id)),
    array('label'=>'Define criteria',           'url'=>array('criteria/create',     'project_id' => $model->project_id)),
    array('label'=>'Define alternatives',       'url'=>array('alternative/create',  'project_id' => $model->project_id)),
    array('label'=>'Evaluation',                'url'=>array('evaluation/evaluate', 'project_id' => $model->project_id)),
    array('label'=>'Results',                   'url'=>array('results/display',     'project_id' => $model->project_id)),
    array('label'=>'Delete Project',            'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->project_id),'confirm'=>'Are you sure to delete this item?')),
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

<?php if(is_array($evaluation) && count($evaluation) > 0) { ?>
    <h2>Evaluation results</h2>
    <?php foreach($evaluation as $Alternative) {?>
        <table>
            <caption><?php echo CHtml::encode($Alternative['Obj']->title); ?></caption>
            <?php $i = 1;?>
            <?php foreach($Alternative['Criteria'] as $Criteria) {?>
                <tr>
                    <td width="250px"><?php echo $i . '. ' . CHtml::encode($Criteria['Obj']->title); ?></td>
                    <?php for($j = 1; $j <= 10; $j++){ ?>
                    <?php $selected = $j <= $Criteria['Evaluation']->grade; ?>
                    <?php $last     = $j == 10; ?>
                    <td <?php if($selected || $last){ ?> class="<?php echo ($selected ?  'selected' : ''); ?> <?php echo ($last ?  'last' : ''); ?>"<?php }?>>&nbsp;</td>
                    <?php }?>
                </tr>
            <?php $i++;?>
            <?php }?>
        </table>
    <?php }?>
<?php }?>

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