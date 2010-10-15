<h1><?php if( $model->isNewRecord) { ?>Create Project<?php } else { ?>Project details<?php }?></h1>
<div id="content">
    <?php $this->pageTitle = Yii::app()->name . ' / ' . ($model->isNewRecord ? 'Create project' : 'Edit project details'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>