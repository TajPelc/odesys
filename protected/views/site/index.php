<?php $this->pageTitle=Yii::app()->name; ?>
<?php if(Project::isProjectActive()) { ?>
<div id="sidebar">
    <p>Your project is still active!</p>
    <span>&nbsp;</span>
</div>
<?php } ?>
<h1>Welcome to ODESYS</h1>
<h2>The on-line decision support system.</h2>
<p>ODESYS helps you reach a better decision.</p>
<p>Say for example that you are buying a new car and choosing among three different models. ODESYS can guide you to the right model for you by providing a graphical overview of each model's characteristics in just a few easy steps.</p>
<ul>
    <li>Create a project</li>
    <li>Define criteria and order them from most to least important (Example: Price, NCAP Rating, Engine Power, Features)</li>
    <li>Define alternatives between which you are choosing (Example: Ford, VW, Audi, Fiat)</li>
    <li>Evalute each alternative by the defined criteria using simple sliders</li>
    <li>Compare alternatives on the graph</li>
    <li>Add/remove criteria or alternatives, reevaluate alternatives or change the importance of different criteria</li>
    <li>Make a better decision armed with additional information provided by ODESYS</li>
</ul>
<p>ODESYS is highly flexible and is suitable for a wide variety of decision problems.</p>
<?php if(!Project::isProjectActive()){ ?><p><?php echo CHtml::link('Start by creating a new project', array('project/create'), array('class' => 'button', 'id' => 'create')); ?></p><?php }?>