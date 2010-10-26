<?php $this->pageTitle=Yii::app()->name . ' - Error'; ?>

<h2><?php echo CHtml::encode($e->title); ?></h2>

<div class="error">
<?php echo CHtml::encode($e->message); ?>
</div>