<?php
$this->breadcrumbs=array(
    $Project->title => array('project/create', 'id' => $Project->project_id),
    'Define criteria' => array('criteria/create'),
    'Define alternatives',
);
?>
<h1>Define alternatives</h1>
<p>Add alternatives between which you are going to be choosing from. In the next steps you will evaluate each alternative by the criteria you defined.</p>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<br />
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'=>'_view',
)); ?>