<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Edit'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
<?php }?>
    <h1>Edit your decision?</h1>
    <form id="editDecision" method="post" action="" class="btcf">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" maxlength="45" value="<?php echo $title;?>" />
        <textarea id="description"><?php echo $description; ?></textarea>
        <label for="privacy">Privacy</label>
        <div id="prettySelectBox">
            <select name="privacy" id="privacy">
                <option value="public">public decision</option>
                <option value="private">private decision</option>
            </select>
        </div>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="close" />
        <input type="submit" name="next" id="next" value="Save" />
    </form>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>
