<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Results'; ?>
<?php $Alternatives = $Project->alternatives; ?>
<?php $Criteria = $Project->criteria; ?>
<h1>Results</h1>
<p>This is the main step of the process to solve your decision problem.</p>
<p>Below is a graphical representation of the evaluation of alternatives by the defined criteria. Points positioned to the right indicate a better score, while points positioned to the left indicate a lower score. From top to bottom of the graph, criteria priority is descending. The most important criteria for your decision problem are listed higher.</p>
<?php $evalCount = count($Project->evaluation); ?>
<?php if(count($Alternatives) * count($Criteria) === $evalCount && $evalCount >= 4) { ?>
<p>Click on various alternatives to see which one would help you reach your goals best.</p>
<p><em>Note: If you choose to disable the use of fixed weights, all criteria is of equal importance (weight) and the scores are recalculated.</em></p>
<hr />
<h2>Graphical analysis: Compare alternatives</h2>
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
            <input type="checkbox" name="series<?php echo $i; ?>" id="series<?php echo $i; ?>" value="<?php echo CHtml::encode($Alternatives[$i-1]->title); ?>">
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
<hr />
<h2>Project details</h2>
<dl>
    <dt><?php echo CHtml::encode($Project->title); ?></dt>
    <dd><?php echo nl2br(CHtml::encode($Project->description));?></dd>
</dl>
<h3>Criteria</h3>
<ul>
    <?php foreach($Criteria as $C) { ?>
        <li>
            <dl>
                <dt><?php echo CHtml::encode($C->title)?></dt>
                <dd><?php echo nl2br(CHtml::encode($C->description)) ?></dd>
            </dl>
        </li>
    <?php }?>
</ul>
<h3>Alternatives</h3>
<ul>
    <?php foreach($Alternatives as $A) { ?>
        <li>
            <dl>
                <dt><?php echo CHtml::encode($A->title) ?></dt>
                <dd><?php echo nl2br(CHtml::encode($A->description)) ?></dd>
            </dl>
        </li>
    <?php }?>
</ul>

<?php } else { ?>
<h2>Evaluation not completed</h2>
<p>Please return to the evaluation page and redo the evaluation, then return here to see the results.</p>
<?php }?>