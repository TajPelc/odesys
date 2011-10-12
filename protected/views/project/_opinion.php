<?php foreach($models as $Opinion) { ?>
    <li>
        <?php echo CHtml::image('https://graph.facebook.com/' . $Opinion->User->facebook_id . '/picture'); ?>
        <div>
            <span class="author"><?php echo CHtml::encode($Opinion->User->name); ?> says:</span>
            <span class="timestamp"><?php echo date('F jS, Y \a\t H:i', strtotime($Opinion->created)); ?></span>
            <p><?php echo nl2br(CHtml::encode($Opinion->opinion)); ?></p>
            <span class="last">&nbsp;</span>
        </div>
    </li>
<?php } ?>