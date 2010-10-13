<?php if(!Ajax::isAjax() && !empty($Project)) {?>
    <div id="project">
<?php }?>
    <?php if(!empty($Project)) { ?>
        <?php  echo CHtml::link('', array('project/view', 'unsetProject' => '1'), array('class' => 'close', 'title' => 'Deactivate current project'));?>
        <h1><?php echo CHtml::encode($Project->title) ?></h1>
        <div>
            <?php if(!empty($this->pages)){ ?>
                <ul>
                    <?php $i = 1;?>
                    <?php foreach($this->pages as $label => $route) {?>
                        <?php $nrLabel = $i . '. ' . $label; ?>
                        <?php if(current($route) === $currentRoute) { ?>
                            <li><span><?php echo CHtml::encode($nrLabel); ?></span></li>
                        <?php } else { ?>
                            <li><?php echo CHtml::link(CHtml::encode($nrLabel), $route, array('title' => CHtml::encode($label))); ?></li>
                        <?php } ?>
                        <?php $i++;?>
                    <?php } ?>
                </ul>
            <?php }?>
        </div>
    <?php }?>
<?php if(!Ajax::isAjax() && !empty($Project)){?>
    </div>
<?php }?>