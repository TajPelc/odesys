<?php $this->beginContent('application.views.layouts.main'); ?>
<?php $Project = Project::getActive(); ?>
<div id="projectUrl">
    <h1><?php echo CHTML::encode($Project->title);?></h1>
    <form action="">
        <fieldset>
            <input class="ui-widget input ui-corner-all ui-widget-content" type="text" name="dummy" value="<?php echo Yii::app()->createAbsoluteUrl('project/set',array('i'=>$Project->url));?>" />
            <input type="button" value="Add to bookmarks!" name="addToBookMarks" class="hidden ui-button ui-widget ui-state-default ui-corner-all">
        </fieldset>
    </form>
</div>
<?php $this->widget('application.components.ProjectMenu'); ?>
<div class="container">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>