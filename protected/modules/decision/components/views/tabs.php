<?php if(!Ajax::isAjax() && !empty($Project)) {?>
<div id="projectBg">
    <div id="project">
    <?php }?>
        <?php if(!empty($Project) && !empty($menu)) { ?>
            <ul>
                <?php $i = 1;?>
                <?php foreach($menu as $id => $menuItem) {?>
                    <?php $activeItem = ($menuItem['route'][0] === $currentRoute); ?>
                    <?php $lastEnabledItem = ($id === $lastEnabled); ?>
                    <?php $lastItem = ($i === count($menu));?>
                    <?php $label = $menuItem['label']; ?>
                    <?php if($menuItem['enabled'] && !$activeItem) {?>
                        <li>
                            <?php echo CHtml::link(CHtml::encode($label), array($menuItem['path'], 'decisionId' => $Project->project_id, 'label' => $Project->label), array('title' => CHtml::encode($label), 'id' => $id)); ?>
                            <span class="loadingBar<?php echo ( $lastEnabledItem && !$lastItem ? ' end' : ''); ?>">&nbsp;</span>
                        </li>
                    <?php } else { ?>
                        <li>
                            <span id="<?php echo $id; ?>" class="<?php echo (($activeItem) ? 'selected' : 'restricted'); ?>"><?php echo CHtml::encode($label); ?></span>
                            <?php if($activeItem) { ?><span class="loadingBar<?php echo (($lastEnabledItem && !$lastItem) ? ' end' : ''); ?>">&nbsp;</span><?php } ?>
                        </li>
                    <?php } ?>
                    <?php $i++;?>
                <?php } ?>
            </ul>
        <?php }?>
    <?php if(!Ajax::isAjax() && !empty($Project)){?>
    </div>
</div>
<?php }?>