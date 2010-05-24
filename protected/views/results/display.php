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

<?php $i = 1; ?>
<?php foreach($evaluation as $Alternative) {?>
    <?php $val = array(); ?>
    <?php $total = count($Alternative['Criteria']); ?>
    <?php foreach($Alternative['Criteria'] as $Criteria) {?>
        <?php $val[] = array((int)$Criteria['Evaluation']->grade * 10, CHtml::encode($Criteria['Obj']->title)); ?>
    <?php }?>
    <div id="chartdiv<?php echo $i;?>" style="width:100%;height:<?php echo $total * 50?>px; margin-bottom: 40px;"></div>
    <script type="text/javascript">
    xticks = [-10, 0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110];

    $.jqplot('chartdiv<?php echo $i;?>',  [ <?php echo json_encode($val); ?> ], {
        seriesColors: [ "#ff5800" ],
        legend:{show:true},
        sortData: false,
        title: {
            text: '<?php echo CHtml::encode($Alternative['Obj']->title); ?>',
            show: true,
            fontSize: '15pt',
            textColor: 'black',
        },
        grid: {background:'#EBF0FA', gridLineColor:'#ccc', borderColor:'#ccc', shadow: false},
        seriesDefaults:[{
            shadow: true,
        }],
        series:[{
            lineWidth:2.5,
            markerOptions:{style:'square'},
            showLabel: false,
        }],
        axes:{
            xaxis:{label: 'Ocena', ticks:xticks, tickOptions:{formatString:'%d', fontSize:'10pt'},showMinorTicks:true,tickInterval: 10},
            yaxis:{renderer:$.jqplot.CategoryAxisRenderer}
        },
        highlighter: {sizeAdjust: 8,formatString:'Ocena: %1s',lineWidthAdjust: 4},
        cursor: {show: false}
    });
    </script>
    <?php $i++; ?>
<?php }?>
<!--
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
 -->