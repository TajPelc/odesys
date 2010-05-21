<div class="view" id="cr<?php echo $data->criteria_id; ?>">
    <h3><?php echo CHtml::encode($data->title); ?></h3>
    <b><?php echo CHtml::encode($data->getAttributeLabel('best')); ?>:</b>
    <?php echo CHtml::encode($data->best); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('worst')); ?>:</b>
    <?php echo CHtml::encode($data->worst); ?>
    <br />
    <br />
    <?php if((bool)$data->description){ ?>

    <p><?php echo CHtml::encode($data->description); ?></p>
    <?php }?>
    <hr />
    <p><a href="<?php echo $this->createUrl('create', array('criteria_id' => $data->criteria_id)); ?>">Edit</a> | <a href="<?php echo $this->createUrl('delete', array('criteria_id' => $data->criteria_id)); ?>">Delete</a></p>
</div>