<?php $this->pageTitle=Yii::app()->name . ' | Welcome'; ?>
<div id="heading">
    <h2>Need to decide? We can help.</h2>
</div>

<div id="content">
    <?php if(Yii::app()->user->isGuest) { ?>
    <h2>Do you already have an account on one of these sites?</h2>
    <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login')); ?>
    <hr />
    <?php } else { ?>
    <a href="#" class="buttonBig projectNew" style="clear: left; width: 100px; text-align: center; margin: 0 0 10px 10px;">
        Start here
        <span class="doors"></span>
    </a>
    <hr />
    <?php } ?>
    <div>
        <dl>
            <dt>What is it?</dt>
            <dd>ODESYS is a simple online decision support system (DSS) with a friendly graphical user interface.</dd>
        </dl>
        <dl>
            <dt>How does it work?</dt>
            <dd>It ask you questions about your decision and helps you evaluate your alternatives, then presents the results in a graphical way.</dd>
        </dl>
        <dl>
            <dt>What may I use it for?</dt>
            <dd>A wide variety of decision problems. Give it a try by clicking the start here button on top!</dd>
        </dl>
        <hr />
        <dl>
            <dt>Important Notice</dt>
            <dd>This is a project under development. We'll be happy to <?php echo CHtml::link('receive', array('site/contact'), array('style' => 'font-weight: bold; text-decoration:underline;')); ?> your opinions, comments and suggestions.</dd>
        </dl>

    </div>
    <img src="../../images/introduction.png" title="Examples from the decision making process" alt="Examples from the decision making process" />
</div>