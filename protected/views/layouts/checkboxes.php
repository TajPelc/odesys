<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="container">
    <?php $this->widget('application.components.ProjectMenu'); ?>
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
    <div class="span-5 last">
        <!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>