<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Results'; ?>
<?php $Alternatives = $Project->alternatives; ?>
<?php $Criteria = $Project->criteria; ?>
<h1>Results</h1>
<p>This is the main step of the process to solve your decision problem.</p>
<p>Below is a graphical representation of the evaluation of alternatives by the defined criteria. Points positioned to the right indicate a better score, while points positioned to the left indicate a lower score. From top to bottom of the graph, criteria priority is descending. The most important criteria for your decision problem are listed higher.</p>
<?php $evalCount = count($Project->evaluation); ?>
<?php if(count($Alternatives) * count($Criteria) === $evalCount && $evalCount >= 4) { ?>
<p>Click on various alternatives to see which one would help you reach your goals.</p>
<h2>Graphical analyses: Compare alternatives</h2>
<?php echo Chtml::link('Select all', array('#'), array('class' => 'button margins', 'id' => 'select'));?>
<?php echo Chtml::link('Deselect all', array('#'), array('class' => 'button margins', 'id' => 'deselect'));?>
<div id="legend">
    <form action="post" id="seriesPicker">
    <ul>
        <?php for($i=0; $i < count($Alternatives); $i++) { ?>
        <?php $favoured = $Alternatives[$i]->alternative_id == current(array_keys($max)); ?>
        <li<?php if($favoured) {?> class="favoured"<?php }?>>
            <?php if($favoured) {?><span class="favoured">High Score</span><?php }?>
            <span style="background-color: <?php echo $colorPool[$i]; ?>;">&nbsp;</span>
            <input type="checkbox" name="series<?php echo $i; ?>" id="series<?php echo $i; ?>" <?php if($i < 2){ ?>checked="checked"<?php }?> value="<?php echo CHtml::encode($Alternatives[$i-1]->title); ?>">
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
<p><em>Note: High score is calculated by an ODESYS algorithm using fixed weights and should not be considered as a definitive answer to your decision problem. It is a piece of additional information for you to take into consideration when deciding.</em></p>
<?php } else { ?>
<h2>Evaluation not completed</h2>
<p>Please return to the evaluation page and redo the evaluation, then return here to see the results.</p>
<?php }?>