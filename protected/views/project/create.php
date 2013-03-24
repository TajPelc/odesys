<?php $this->pageTitle = 'Create a new Decision | odesys'; ?>

<?php if(Yii::app()->request->isAjaxRequest) { ?>
    <h1>What would you like to decide?</h1>
    <form id="projectCreate" method="post" action="" class="btcf">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="e.g. Which car to buy" />
        <label for="privacy">Privacy</label>
        <div id="prettySelectBox">
            <select name="privacy" id="privacy">
                <option value="<?php echo Decision::PRIVACY_EVERYONE; ?>">public decision</option>
                <option value="<?php echo Decision::PRIVACY_ME; ?>">private decision</option>
            </select>
        </div>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="close" />
        <input type="submit" name="next" id="next" value="Next" />
    </form>
<?php }?>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
    <h1>Hmm?! Where can I begin making my decision model?</h1>
    <p>You probably came here by having your <b>JavaScript disabled</b> when clicking either the "begin your journey" or "new decision" links.</p>
    <p>While we could let you proceed with making your decision model without JavaScript, we will not do that because the process later on is very JavaScript dependant and the use of JavaScript is mandatory.</p>
    <p>Make sure your <b>JavaScript</b> is <b>enabled</b> and proceed by clicking the <?php echo CHtml::link('"new decision"', array('/project/create'), array('title' => 'Create a new decision', 'class' => 'decisionNew')); ?> link.</p>
</section>
<?php } ?>


