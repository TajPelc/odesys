<?php $this->pageTitle = 'Login | odesys'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
<?php }?>
    <?php if($connectToAccount) { ?>
        <h1>Consider logging in</h1>
        <p>To <b>keep</b> your <b>decision model</b> permanently please <b>log in</b> with a social account.</p>
        <p>Don’t worry. We don’t require any special permissions. Your data is safe with us, we won’t share it with anyone without your permission.</p>
        <p>If you decide not to log in, you are still able to finish the process, but you won't be able to make any changes to the decision model once you leave the page. Read the full <?php echo CHtml::link('terms of service', array('/site/terms/'), array('title'=>'about us')); ?> for more information.</p>
    <?php } else { ?>
        <h1>First, choose your preferred account</h1>
        <p>We ask you to log in so that we can offer a superior user experience. Don’t worry. We don’t require any special permissions. Your data is safe with us, we won’t share it with anyone without your permission.</p>
        <p>Read the full <?php echo CHtml::link('terms of service', array('/site/terms/'), array('title'=>'about us')); ?> for more information.</p>
    <?php } ?>
    <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'login/index')); ?>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>
