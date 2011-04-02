<div id="content">
    <?php $this->pageTitle=Yii::app()->name . 'ODESYS: Online Decision Support System'; ?>
    <?php if(Project::isProjectActive()) { ?>
    <?php } ?>
    <dl>
        <dt><em>What is it?</em></dt>
        <dd>ODESYS is a simple online decision support system (<a href="http://en.wikipedia.org/wiki/Decision_support_system" title="Decision Support System">DSS</a>) with a friendly graphical user interface.</dd>
        <dt>How does it work?</dt>
        <dd>It seamlessly guides you through the process of creating a decision model, the evaluation of alternatives and results analysis. Armed with new knowledge the hard part is still up to you. Making a choice.</dd>
        <dt>What may I use it for?</dt>
        <dd>A wide variety of decision problems. A basic understanding of <a href="http://en.wikipedia.org/wiki/Decision_theory" title="Decision making">decision theory</a> is wanted, but not required. Try it out!</dd>
    </dl>
</div>
<div id="sidebar">
    <ul>
        <li class="show">
            <img src="http://www.alohatechsupport.net/examples/image-rotator/images/image-1.jpg" title=""  alt="pic1" />
        </li>
            <li>
            <img src="http://www.alohatechsupport.net/examples/image-rotator/images/image-3.jpg" title=""  alt="pic2" />
        </li>
        <li>
            <img src="http://www.alohatechsupport.net/examples/image-rotator/images/image-2.jpg" title=""  alt="pic3" />
        </li>
        <li>
            <img src="http://www.alohatechsupport.net/examples/image-rotator/images/image-1.jpg" title=""  alt="pic1" />
        </li>
            <li>
            <img src="http://www.alohatechsupport.net/examples/image-rotator/images/image-3.jpg" title=""  alt="pic2" />
        </li>
        <li>
            <img src="http://www.alohatechsupport.net/examples/image-rotator/images/image-2.jpg" title=""  alt="pic3" />
        </li>
    </ul>
    <h2>How to use odesys?</h2>
    <p>First gain a good understanding of your decison problem. You may then proceed to:</p>
    <ol>
        <li class="current"><p>Start by signing in with Facebook and creating a new project</p></li>
        <li><p>Define criteria and order them from most to least important</p></li>
        <li><p>Define alternatives between which you are choosing</p></li>
        <li><p>Evalute each alternative by the defined criteria</p></li>
        <li><p>Analyse the results using our graphical method</p></li>
        <li><p>Make a better decision</p></li>
    </ol>
    <?php if(!Project::isProjectActive()){ ?><p><?php echo CHtml::link('Start by creating a new project', array('criteria/create'), array('class' => 'button', 'id' => 'create')); ?></p><?php }?>
</div>