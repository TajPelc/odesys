<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Results'; ?>
<?php $Alternatives = $Project->alternatives; ?>
<?php $Criteria = $Project->criteria; ?>
<form id="options">
    <label for="display_weighted">Use fixed weights</label>
    <input type="checkbox" name="display_weighted" id="display_weighted" value="1" checked="checked">
</form>
<?php echo Chtml::link('Select all', array('#'), array('class' => 'button margins', 'id' => 'select'));?>
<?php echo Chtml::link('Deselect all', array('#'), array('class' => 'button margins', 'id' => 'deselect'));?>
<div id="legend">
    <form action="post" id="seriesPicker">
    <ul>
        <?php for($i=0; $i < count($Alternatives); $i++) { ?>
        <?php $favoured = false ?>
        <li>
            <span style="background-color: <?php echo $colorPool[$i]; ?>;">&nbsp;</span>
            <input type="checkbox" name="series<?php echo $i; ?>" id="series<?php echo $i; ?>" value="<?php echo CHtml::encode($Alternatives[$i]->title); ?>">
            <label for="series<?php echo $i; ?>"><?php echo CHtml::encode($Alternatives[$i]->title); ?></label>
        </li>
        <?php }?>
    </ul>
    </form>
</div>
<script type="text/javascript">
var chartData = <?php echo json_encode($rv); ?>;
var criteriaWorst = <?php echo json_encode(CHtml::listData($Criteria, 'title', 'worst')); ?>;
var criteriaBest =  <?php echo json_encode(CHtml::listData($Criteria, 'title', 'best')); ?>;
</script>
<div id="chartdiv"></div>

<div id="sidebar" style="width:664px;">
	<p><em>Note: Scores for alternatives are calculated by an ODESYS algorithm and alternatives are sorted by their score from best to worst. Use this as a piece of aditional information when comparing alternatives.</em></p>
	<p><em>Note: If you choose to disable the use of fixed weights, all criteria is of equal importance (weight) and the scores are recalculated.</em></p>
	<p>This is the main step of the process to solve your decision problem.</p>
	<p>It is a graphical representation of the evaluation of alternatives by the defined criteria. Points positioned to the right indicate a better score, while points positioned to the left indicate a lower score. From top to bottom of the graph, criteria priority is descending. The most important criteria for your decision problem are listed higher.</p>
	<?php $evalCount = count($Project->evaluation); ?>
	<?php if(count($Alternatives) * count($Criteria) === $evalCount && $evalCount >= 4) { ?>
	<p>Compare various alternatives to see which one would help you reach your goals best.</p>
	<span class="up">&nbsp;</span>
</div>
<?php } else { ?>
<h2>Evaluation not completed</h2>
<p>Please return to the evaluation page and redo the evaluation, then return here to see the results.</p>
<?php }?>