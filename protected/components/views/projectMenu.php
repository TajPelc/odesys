<div id="project">
    <?php if(!empty($Project)) { ?>
        <span class="first"><?php echo CHTML::link(CHTML::encode($Project->title), array('project/create')); ?></span>
        <?php if(!empty($this->breadcrumbs)){ ?>
            <ul>
                <?php $i = 1;?>
                <?php foreach($this->breadcrumbs as $label => $url) {?>
                    <?php if(is_string($label) || is_array($url)) { ?>
                        <?php $label = $i . '. ' . $label; ?>
                        <li><?php echo CHtml::link(CHtml::encode($label), $url); ?></li>
                    <?php } else { ?>
                        <?php $url = $i . '. ' . $url; ?>
                        <li><span><?php echo CHtml::encode($url); ?></span></li>
                    <?php } ?>
                    <?php $i++;?>
                <?php } ?>
            </ul>
        <?php }?>
    <?php } else { ?>
    <?php }?>
</div>