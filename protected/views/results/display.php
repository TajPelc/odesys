<?php
$this->breadcrumbs=array(
    $Project->title => array('project/create', 'id' => $Project->project_id),
    'Define criteria' => array('criteria/create'),
    'Define alternatives' => array('alternative/create'),
    'Evaluation' => array('evaluation/evaluate'),
    'Results'
);

$i = 0;
foreach($Project->alternatives as $A)
{
    $var[] = array('label'=> CHtml::encode($A->title), 'color'=>$colorPool[$i]);
    $i++;
}
$this->menu = $var;
?>

<h1>Results</h1>

<div id="chartdiv" style="width:100%;height:<?php echo $total * 50?>px; margin-bottom: 40px;"></div>
<div id="chartdiv2" style="width:100%;height:<?php echo $total * 50?>px; margin-bottom: 40px;"></div>