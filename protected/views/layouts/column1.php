<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="container">
    <div id="project">
        <span class="first"><a href="<?php echo $this->createUrl('project/create'); ?>">Izbira grafične kartice za podjetje 3fs d.o.o. iz Kranja</a></span>
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
    </div>
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>