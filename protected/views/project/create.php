<?php $this->pageTitle = ' Create a new Decision | odesys'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
<?php }?>
    <h1>What would you like to decide?</h1>
    <form id="projectCreate" method="post" action="" class="btcf">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="i.e. Which car to buy" />
        <label for="privacy">Privacy</label>
        <div id="prettySelectBox">
            <select name="privacy" id="privacy">
                <option value="<?php echo Decision::PRIVACY_EVERYONE; ?>">public decision</option>
                <option value="<?php echo Decision::PRIVACY_ME; ?>">private decision</option>
            </select>
        </div>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="close" />
        <input type="submit" name="next" id="next" value="Next" />
    </form>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>


