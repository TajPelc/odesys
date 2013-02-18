<?php if(!Ajax::isAjax() && !empty($this->Decision)) {?>
<div id="projectBg">
    <div id="project">
    <?php }?>
        <?php if(!empty($this->Decision) && !empty($this->pages)) { ?>
            <ul class="btcf">
                <?php $i = 1;?>
                <?php foreach($this->pages as $id => $Page) {?>
                    <?php $activePage = ($Page['route'][0] === $currentRoute); ?>
                    <?php $lastEnabledPage = ($id === $lastEnabled); ?>
                    <?php $lastPage = ($i === count($this->pages));?>
                    <?php $label = $Page['label']; ?>
                    <?php if($Page['enabled'] && !$activePage) {?>
                        <li>
                            <?php echo CHtml::link(CHtml::encode($label), array($Page['path'], 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label), array('title' => CHtml::encode($label), 'id' => $id)); ?>
                            <span class="loadingBar<?php echo ( $lastEnabledPage && !$lastPage ? ' end' : ''); ?>">&nbsp;</span>
                        </li>
                    <?php } else { ?>
                        <li>
                            <span id="<?php echo $id; ?>" class="<?php echo (($activePage) ? 'selected' : 'restricted'); ?>"><?php echo CHtml::encode($label); ?></span>
                            <?php if($activePage) { ?><span class="loadingBar<?php echo (($lastEnabledPage && !$lastPage) ? ' end' : ''); ?>">&nbsp;</span><?php } ?>
                        </li>
                    <?php } ?>
                    <?php $i++;?>
                <?php } ?>
            </ul>
        <?php }?>
    <?php if(!Ajax::isAjax() && !empty($this->Decision)){?>
    </div>
</div>
<?php }?>