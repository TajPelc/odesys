<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Delete'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content" xmlns="http://www.w3.org/1999/html">
<?php }?>
    <h1>Are you sure you want to delete a decision model?</h1>
    <p>You are about to delete decision model named "<em><?php echo $title ?></em>"?
    </p>
    <form method="post" action="" class="btcf" id="deleteDecision">
        <input type="button" name="cancel" id="cancel" value="Cancel" class="close" />
        <input type="submit" name="delete" id="delete" value="Yes, delete it" />
    </form>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>