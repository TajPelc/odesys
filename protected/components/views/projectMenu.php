<?php if(!Ajax::isAjax()) {?>
    <div id="project">
<?php }?>
    <?php  if(!empty($Project)) { echo CHtml::link('&times;', array('project/view', 'unsetProject' => '1'), array('class' => 'close', 'title' => 'Deactivate current project')); }?>
    <span class="title">PROJECT</span>
    <?php  if(!empty($Project)) { ?><span class="title"><?php echo CHtml::encode($Project->title) ?></span><?php }?>
    <div<?php if(empty($Project)) { ?> class="dotted"<?php }?>>
        <h1<?php if(!empty($Project)) { ?> style="display: none;"<?php }?>>placeholder</h1>
        <p<?php if(!empty($Project)) { ?> style="display: none;"<?php }?>>Create or activate a project to begin</p>

        <?php if(!empty($Project)) { ?>
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
        <?php }?>
    </div>
<?php if(!Ajax::isAjax()) {?>
    </div>
<?php }?>