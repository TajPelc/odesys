<li>
    <p><b><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'project_id'=>$data->project_id)); ?></b> created <?php echo CHtml::encode(date('\o\n d.m.Y \a\t H:i', strtotime($data->created))); ?> (<?php echo CHtml::link(CHtml::encode('edit'), array('create', 'id'=>$data->project_id)); ?>)</p>
    <p><?php echo CHtml::encode($data->description); ?></p>
</li>