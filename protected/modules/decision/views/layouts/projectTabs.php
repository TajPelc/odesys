<?php $this->beginContent('application.views.layouts.main'); ?>
<?php $this->widget('application.modules.decision.components.Tabs', array('Decision' => $this->Decision, 'pages' => $this->_pages)); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>
