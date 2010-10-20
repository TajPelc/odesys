<?php $this->pageTitle=Yii::app()->name; ?>
<?php if(Project::isProjectActive()) { ?>
<?php } ?>
<h1>Welcome to ODESYS</h1>
<dl>
    <dt><em>What is it?</em></dt>
    <dd>ODESYS is a simple online decision support system (<a href="http://en.wikipedia.org/wiki/Decision_support_system" title="Decision Support System">DSS</a>) with a friendly graphical user interface.</dd>
    <dt>How does it work?</dt>
    <dd>It seamlessly guides you through the process of creating a decision model, the evaluation of alternatives and results analysis. Armed with new knowledge the hard part is still up to you. Making a choice.</dd>
    <dt>What may I use it for?</dt>
    <dd>A wide variety of decision problems. A basic understanding of <a href="http://en.wikipedia.org/wiki/Decision_theory" title="Decision making">decision theory</a> is wanted, but not required. Try it out!</dd>
</dl>
<h2>How to use odesys?</h2>
<p>First gain a good understanding of your decison problem. You may then proceed to:</p>
<ol>
    <li><p>Create a new project</p></li>
    <li><p>Define criteria and order them from most to least important</p></li>
    <li><p>Define alternatives between which you are choosing</p></li>
    <li><p>Evalute each alternative by the defined criteria</p></li>
    <li><p>Analyse the results using a graphical interpretation of results</p></li>
    <li><p>Add/remove criteria or alternatives, reevaluate alternatives or change the order (importance) of criteria</p></li>
    <li><p>Make a better decision</p></li>
</ol>
<p></p>
<?php if(!Project::isProjectActive()){ ?><p><?php echo CHtml::link('Start by creating a new project', array('project/create'), array('class' => 'button', 'id' => 'create')); ?></p><?php }?>