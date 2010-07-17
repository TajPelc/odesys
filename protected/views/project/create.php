<?php $this->pageTitle = Yii::app()->name . ' / ' . ($model->isNewRecord ? 'Create project' : 'Edit project details'); ?>
<h1><?php if( $model->isNewRecord) { ?>Create Project<?php } else { ?>Project details<?php }?></h1>
<p><?php if( $model->isNewRecord) { ?>Create a project by filling in the form. Choose a title and write a short description about the nature of your decision problem, your goals, expectations, notes or other.<?php } else { ?>Modify values in the form to edit active project's details.<?php }?></p>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>