<div class="view">
    <h3><?php echo CHtml::encode($data->title); ?></h3>
    <p><?php echo CHtml::encode($data->description); ?></p>
    <hr />
    <p><a href="<?php echo $this->createUrl('create', array('alternative_id' => $data->alternative_id)); ?>">Edit</a> | <a href="<?php echo $this->createUrl('delete', array('alternative_id' => $data->alternative_id)); ?>">Delete</a></p>

</div>