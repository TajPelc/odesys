<?php
$this->breadcrumbs=array(
    'Edit project details' => array('project/create', 'id' => $Project->project_id),
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
<h2>Legend</h2>
<p>Click on various alternatives to disable or enable them on ABACON. You must select at least one alternative.</p>
<div id="legend">
    <form action="post" id="seriesPicker">
    <ul>
        <?php for($i=0; $i < count($this->menu); $i++) { ?>
        <li>
            <span style="background-color: <?php echo $this->menu[$i]['color']; ?>;">&nbsp;</span>
            <input type="checkbox" name="series<?php echo $i; ?>" id="series<?php echo $i; ?>" <?php if($i < 2){ ?>checked="checked"<?php }?> value="<?php echo $this->menu[$i-1]['label']; ?>">
            <label for="series<?php echo $i; ?>"><?php echo $this->menu[$i]['label']; ?></label>
        </li>
        <?php }?>
    </ul>
    </form>
</div>
<h2>ABACON</h2>
<p>Graphical representation of the evaluation of alternatives by the defined criteria. Points positioned to the right indicate a better score, while points positioned to the left indicate a lower score. From top to bottom of the graph, criteria priority is descending.</p>
<div id="chartdiv"></div>