<?php $this->pageTitle=Yii::app()->name; ?>

<p>Welcome to ODESYS ALPHA. Online decision support system.</p>

<p>Workflow:</p>
<ul>
    <li>Start a project</li>
    <li>Define criteria by priority from highest to lowest</li>
    <li>Define alternatives between which you are choosing</li>
    <li>Evalute each alternative by the defined criterias on a scale from 1 to 10</li>
    <li>Be presented with a graphical interpretation of the results</li>
</ul>

<p><a href="<?php echo $this->createUrl('project/create'); ?>">Start here</a></p>