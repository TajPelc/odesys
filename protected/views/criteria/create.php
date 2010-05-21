<?php
$this->breadcrumbs = array(
    $Project->title => array('project/create', 'id' => $Project->project_id),
    'Define criteria',
);
?>

<h1>Define criteria</h1>
<p>Add criteria by importance from most to least important. Click add to add a criteria, click next to finish adding and continue with the process.</p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<br />
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'=>'_view',
)); ?>