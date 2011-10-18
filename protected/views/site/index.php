<?php $this->pageTitle=Yii::app()->name . ' | Welcome'; ?>
<div id="heading">
    <h2>Need to decide? We can help.</h2>
</div>

<div id="content">
    <div>
        <dl>
            <dt style="color: #c70000">ODESYS PUBLIC TEST</dt>
            <dd>This is a pre-release version of the new ODESYS. Please feel free to play around with the system and <?php echo CHtml::link('report', array('site/contact'), array('style' => 'font-weight: bold; text-decoration:underline;')); ?> any bugs that you may find.  We'll be happy to hear your opinions, comments and suggestions. Invite your friends!</dd>
            <dd style="margin-top: 10px;">Logging in with a Google account is comming in the near future!</dd>
            <dd style="margin-top: 10px;">The application look and feel might change during the testing period.</dd>
            <dd style="margin-top: 10px; font-weight: bold;">Note that after the testing period is over, we will reset the database!</dd>
        </dl>
        <hr />
        <dl>
            <dt>What is it?</dt>
            <dd>ODESYS is a simple online decision support system (DSS) with a friendly graphical user interface.</dd>
        </dl>
        <dl>
            <dt>How does it work?</dt>
            <dd>It seamlessly guides you through the process of creating a decision model, the evaluation of alternatives and the analysis of results. You may then Collaborate on a decision with friends to get more insight into the problem and use the knowledge gained to make a better decision!</dd>
        </dl>
        <dl>
            <dt>What may I use it for?</dt>
            <dd>A wide variety of decision problems. We guide you through the process step by step. Start by <?php echo CHtml::link('logging in', array('login/facebook'), array('style' => 'font-weight: bold; text-decoration:underline;')); ?> with Facebook. Try it out!</dd>
        </dl>
    </div>
    <img src="../../images/introduction.png" title="Examples from the decision making process" alt="Examples from the decision making process" />
</div>