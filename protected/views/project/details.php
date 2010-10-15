<div id="content">
<h1>Description</h1>
<?php if((bool)$Project->description) { ?><p><?php echo CHtml::encode($Project->description); ?><?php }?></p>
<p><?php echo CHtml::link('Edit', array('project/create'), array('class' => 'button', 'id' => 'create')); ?></p>
</div>
<div id="sidebar">
    <p>Add between 2 and 10 criteria for rating the alternatives. Provide best (most desired) and worst (least desired) values. Set the best and worst values low or high enough that no alternative that you are considering falls under or over this marign.</p>
    <p>Sample criteria: Max speed / <em>Worst:</em> 140kph / <em>Best:</em> 220kph, Price / <em>Worst:</em> 25.000€ / <em>Best:</em> 10.000€</p>
</div>