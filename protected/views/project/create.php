<?php $this->pageTitle = Yii::app()->name . ' / Login'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content">
<?php }?>
    <h1>What would you like to decide?</h1>
    <form method="post" action="" class="btcf">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="Buying a car" />
        <label for="privacy">Privacy</label>
        <div id="prettySelectBox">
            <select name="privacy" id="privacy">
                <option value="public">public decision</option>
                <option value="private">private decision</option>
            </select>
        </div>
        <input type="button" name="cancel" id="cancel" value="Cancel" class="close" />
        <input type="button" name="next" id="next" value="Next" />
    </form>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>


