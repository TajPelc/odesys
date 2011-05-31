<?php $this->pageTitle=CHtml::encode($e->title); ?>

<div id="heading">
    <h2><?php echo CHtml::encode($e->title); ?></h2>
</div>

<div id="content">
    <div class="error">
        <?php echo CHtml::encode($e->message); ?>
    </div>
</div>
