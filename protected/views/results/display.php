<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Results'; ?>
<?php $Alternatives = $Project->alternatives; ?>
<h1>Results</h1>
<?php $evalCount = count($Project->evaluation); ?>
<?php if(count($Alternatives) * count($Project->criteria) === $evalCount && $evalCount >= 4) { ?>
<h2>Legend</h2>
<p>Click on various alternatives to disable or enable them on ABACON. You must select at least one alternative.</p>
<div id="legend">
    <form action="post" id="seriesPicker">
    <ul>
        <?php for($i=0; $i < count($Alternatives); $i++) { ?>
        <?php $favoured = $Alternatives[$i]->alternative_id == current(array_keys($max)); ?>
        <li<?php if($favoured) {?> class="favoured"<?php }?>>
            <span style="background-color: <?php echo $colorPool[$i]; ?>;">&nbsp;</span>
            <input type="checkbox" name="series<?php echo $i; ?>" id="series<?php echo $i; ?>" <?php if($i < 2){ ?>checked="checked"<?php }?> value="<?php echo CHtml::encode($Alternatives[$i-1]->title); ?>">
            <label for="series<?php echo $i; ?>"><?php echo CHtml::encode($Alternatives[$i]->title); ?></label>
            <?php if($favoured) {?><span class="favoured">High Score</span><?php }?>
        </li>
        <?php }?>
    </ul>
    </form>
</div>
<h2>ABACON</h2>
<p>Graphical representation of the evaluation of alternatives by the defined criteria. Points positioned to the right indicate a better score, while points positioned to the left indicate a lower score. From top to bottom of the graph, criteria priority is descending.</p>
<div id="chartdiv"></div>
<p><em>Note: High score is calculated by an ODESYS algorithm using fixed weights and should not be considered as a definitive answer to your decision problem. It is a piece of additional information for you to take into consideration when deciding.</em></p>
<?php } else { ?>
<h2>Evaluation not completed</h2>
<p>Please return to the evaluation page and redo the evaluation, then return here to see the results.</p>
<?php }?>