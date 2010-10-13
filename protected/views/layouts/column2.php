<?php $this->beginContent('application.views.layouts.main'); ?>
<?php $this->widget('application.components.ProjectMenu'); ?>
<div class="container">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>