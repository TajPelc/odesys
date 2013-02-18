<?php $this->pageTitle = Yii::app()->name . ' / Login'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
<?php }?>
    <h1>First, choose your preffered account</h1>
    <p>We ask you to log in so that we can offer a superior user experience. Don’t worry. We don’t require any special permissions. Your data is safe with us, we won’t share it with anyone without your permission. Read the full <a href="#">terms of service</a> for more information.</p>
    <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'login/index')); ?>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>
