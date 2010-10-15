<?php $this->beginContent('application.views.layouts.main'); ?>
<?php $Project = Project::getActive(); ?>
<?php if((bool)$Project){ ?>
<div id="projectUrl">
    <h1><?php echo CHtml::encode($Project->title);?></h1>
    <form action="">
        <fieldset>
            <input id="projectUrl_input" class="ui-widget input ui-corner-all ui-widget-content" type="text" name="dummy" value="<?php echo Yii::app()->createAbsoluteUrl('project/set',array('i'=>$Project->url));?>" />
            <input type="button" value="Add to bookmarks!" name="addToBookMarks" id="addToBookMarks" class="hidden ui-button ui-widget ui-state-default ui-corner-all" title="ODESYS: <?php echo CHtml::encode($Project->title);?>" href="">
            <?php echo CHtml::link('Add to bookmarks!', Yii::app()->createAbsoluteUrl('project/set',array('i'=>$Project->url)), array('class' => 'button', 'id' => 'addToBookMarks')); ?>
            <span>Copy url or -></span>
        </fieldset>
    </form>
</div>
<?php } ?>
<?php $this->widget('application.components.ProjectMenu'); ?>
<div class="container">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>