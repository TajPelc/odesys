<div id="content">
    <?php $this->pageTitle=Yii::app()->name . 'Contact ODESYS'; ?>

    <h1>Contact us:</h1>

    <form method="post" action="">
        <fieldset>
            <label for="contact_subject">Subject:</label>
            <input type="text" name="contact_subject" id="contact_subject" />
            <label for="contact_description">Description:</label>
            <textarea id="contact_description"></textarea>
            <input type="submit" name="save" value="Send" />
        </fieldset>
    </form>

</div>