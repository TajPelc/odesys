<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="container">
    <?php $this->widget('application.components.ProjectMenu', array('breadcrumbs' => $this->breadcrumbs)); ?>
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>