<div id="project">
    <?php if(!empty($Project)) { ?>
        <?php require_once(dirname(__FILE__).'../../../../../yii/framework/web/helpers/CHtml.php'); // FUCKING UGLY HACK - FIGURE IT OUT!!!?>
        <span><?php echo CHTML::link(CHTML::encode($Project->title), array('project/view')); ?></span>
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
    <?php }?>
</div>