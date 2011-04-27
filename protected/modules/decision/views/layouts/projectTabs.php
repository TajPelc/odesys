<?php $this->beginContent('application.views.layouts.main'); ?>
<?php $this->widget('application.modules.decision.components.Tabs', array('Decision' => $this->Decision, 'pages' => $this->_pages)); ?>
<div id="main">
    <?php echo $content; ?>
    <div id="mainEnd"></div>
</div>
<?php $this->endContent(); ?>
