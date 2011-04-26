<?php $this->beginContent('application.views.layouts.main'); ?>
<?php $Project = Project::getActive(); ?>
<?php if((bool)$Project){ ?>
    <?php $this->widget('application.modules.decision.components.Tabs'); ?>
<?php } ?>
<div id="main">
    <?php echo $content; ?>
    <div id="mainEnd"></div>
</div>
<?php $this->endContent(); ?>
