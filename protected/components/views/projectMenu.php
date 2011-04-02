<?php if(!Ajax::isAjax() && !empty($Project)) {?>
<div id="projectBg">
    <div id="project">
    <?php }?>
        <?php if(!empty($Project)) { ?>
            <?php if(!empty($menu)){ ?>
                <ul>
                    <?php $i = 1;?>
                    <?php foreach($menu as $id => $menuItem) {?>
                        <?php $label = $i . '. ' . $menuItem['label']; ?>
                        <?php if($menuItem['route'][0] === $currentRoute) { ?>
                            <li><span id="<?php echo $id; ?>" class="<?php if($menuItem['enabled']) {?>selected<?php } else { ?>restricted<?php }?>"><?php echo CHtml::encode($label); ?></span><span class="loadingBar"></span><span class="loadingBarEnd">&nbsp;</span></li>
                        <?php } elseif (!$menuItem['enabled']) { ?>
                            <li><span id="<?php echo $id; ?>" class="<?php if($menuItem['enabled']) {?>selected<?php } else { ?>restricted<?php }?>"><?php echo CHtml::encode($label); ?></span></li>
                        <?php } else { ?>
                            <li><?php echo CHtml::link(CHtml::encode($label), $menuItem['route'], array('title' => CHtml::encode($label), 'id' => $id)); ?><span class="loadingBar">&nbsp;</span><span class="loadingBarEnd">&nbsp;</span></li>
                        <?php } ?>
                        <?php $i++;?>
                    <?php } ?>
                </ul>
            <?php }?>
        <?php }?>
    <?php if(!Ajax::isAjax() && !empty($Project)){?>
    </div>
</div>
<?php }?>