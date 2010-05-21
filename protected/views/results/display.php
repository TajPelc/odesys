<?php
$this->breadcrumbs=array(
    $Project->title => array('project/create', 'id' => $Project->project_id),
    'Define criteria' => array('criteria/create'),
    'Define alternatives' => array('alternative/create'),
    'Evaluation' => array('evaluation/evaluate'),
    'Results'
);

$this->menu=array(
    array('label'=>'?', 'url'=>array('?')),
    array('label'=>'?', 'url'=>array('?')),
);
?>

<h1>Results</h1>
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