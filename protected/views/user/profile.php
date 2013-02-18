<?php $this->pageTitle='Profile | Decision feed'; ?>
<section class="content">
    <h1>Welcome <b><?php echo substr(Yii::app()->user->name, 0, strpos(Yii::app()->user->name, ' ')); ?></b>, thank you for logging in with your social account. You may now use all the features of odesys.</h1>
    <div>
        <?php echo CHtml::link('create a new decision', array('/site/login/'), array('class'=>'decisionNew', 'title'=>'create a new decision')); ?>
    </div>
</section>
<section class="accounts">
    <div class="btcf">
        <h1>Account management</h1>
        <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login')); ?>
        <?php echo CHtml::link('delete my account', array('/'), array('id'=>'delete', 'title'=>'delete my account')); ?>
    </div>
</section>



<?php if(!empty($Decisions)) { ?>
<table>
    <tr>
        <th>Decision name</th>
        <th>Last modified</th>
        <th>No. opinions</th>
        <th>Published to</th>
        <th class="l"></th>
    </tr>
    <?php foreach($Decisions as $D) { ?>
    <tr id="<?php echo $D->decision_id; ?>">
        <td><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '.html'); ?></td>
        <td><?php echo date('j.n.Y', strtotime($D->last_edit)); ?></td>
        <td><?php echo $D->opinionCount; ?></td>
        <td>
            <div>
                <?php
                if($D->isPublished()) {
                    if($D->isPrivate()) {
                        echo 'Private';
                    } elseif ($D->isFriendsOnly()) {
                        echo 'Friends';
                    } elseif ($D->isPublic()) {
                        echo 'Everyone';
                    }
                } else {
                    echo '<em>Not yet</em>';
                }?>
            </div>
        </td>
        <td class="l"><div><span>X</span></div></td>
    </tr>
    <?php } ?>
</table>
<?php } else { ?>
<h3>You don't have any decisions yet. Start by creating one.</h3>
<?php } ?>



<section class="decisions">
    <h1>My latest decisions</h1>
    <table>
        <thead>
            <tr>
                <th>decision name</th>
                <th>visible</th>
                <th>edit</th>
                <th>delete</th>
            </tr>
        </thead>
        <tr>
            <td><a href="#">Buying a second-hand sports car</a></td>
            <td>public</td>
            <td><a href="#" class="edit">edit</a></td>
            <td><a href="#" class="delete">delete</a></td>
        </tr>
        <tr>
            <td>Buying a second-hand sports car</td>
            <td>private</td>
            <td><a href="#" class="edit">edit</a></td>
            <td><a href="#" class="delete">delete</a></td>
        </tr>
        <tr>
            <td>Buying a second-hand sports car</td>
            <td>private</td>
            <td><a href="#" class="edit">edit</a></td>
            <td><a href="#" class="delete">delete</a></td>
        </tr>
    </table>
</section>
