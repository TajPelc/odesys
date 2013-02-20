<?php $this->pageTitle = Yii::app()->name . ' / Delete'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>
<section class="content" xmlns="http://www.w3.org/1999/html">
<?php }?>
    <h1>Are you sure you want to delete your profile?</h1>
    <p>By deleting your profile you will lose all the hard work you have done. If you are sure this is what you want, press "Delete profile" button. Keep in mind that this action is irreversible.</p>
    <h2>Which data gets deleted?</h2>
    <ul>
        <li>Your profile.</li>
        <li>Your decisions.</li>
        <li>Your opinions.</li>
        <li>Notifications about your actions.</li>
    </ul>
    <form method="post" action="" class="btcf" id="deleteUser">
        <input type="button" name="cancel" id="cancel" value="Cancel" class="close" />
        <input type="submit" name="delete" id="delete" value="Delete & Logout" />
    </form>
<?php if(!Yii::app()->request->isAjaxRequest) { ?>
</section>
<?php } ?>
