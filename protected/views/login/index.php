<?php $this->pageTitle = Yii::app()->name . ' / Login'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
<?php }?>
    <h1>First, choose your preffered account</h1>
    <?php if($isGuest) { ?>
        <p>To keep your decision model permanently please log in with a social account. Don’t worry. We don’t require any special permissions. Your data is safe with us, we won’t share it with anyone without your permission. Read the full <a href="#">terms of service</a> for more information. If you decide not to log in, you are still able to finish the process, but you won't be able to make any changes to the decision model once you leave the page.</p>
    <?php } else { ?>
        <p>We ask you to log in so that we can offer a superior user experience. Don’t worry. We don’t require any special permissions. Your data is safe with us, we won’t share it with anyone without your permission. Read the full <a href="#">terms of service</a> for more information.</p>
    <?php } ?>
    <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'login/index')); ?>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>
