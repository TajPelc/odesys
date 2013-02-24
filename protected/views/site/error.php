<?php $this->pageTitle=CHtml::encode($e->title); ?>

<section class="content">
    <heading>
        <h1><?php echo CHtml::encode($e->title); ?></h1>
    </heading>
    <div class="error">
        <?php echo CHtml::encode($e->message); ?>
    </div>
</section>
