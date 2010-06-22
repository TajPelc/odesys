<div id="project">
    <div<?php if(empty($Project)) { ?> class="padded"<?php }?>>
    <?php if(!empty($Project)) { ?>
        <span><?php echo CHtml::link(CHtml::encode($Project->title), array('project/view', 'unsetProject' => '1')); ?></span>
        <?php if(!empty($this->pages)){ ?>
            <ul>
                <?php $i = 1;?>
                <?php foreach($this->pages as $label => $route) {?>
                    <?php $label = $i . '. ' . $label; ?>
                    <?php if(current($route) === $currentRoute) { ?>
                        <li><span><?php echo CHtml::encode($label); ?></span></li>
                    <?php } else { ?>
                        <li><?php echo CHtml::link(CHtml::encode($label), $route); ?></li>
                    <?php } ?>
                    <?php $i++;?>
                <?php } ?>
            </ul>
        <?php }?>
    <?php } else {  ?>
            <h1>Project placeholder</h1>
            <p>To begin, create or activate a project.</p>
    <?php }?>
    </div>
</div>