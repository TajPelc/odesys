<?php $this->pageTitle='Profile | Decision feed'; ?>
<section class="content">
    <h1>Welcome <b><?php echo substr(Yii::app()->user->name, 0, strpos(Yii::app()->user->name, ' ')); ?></b>, thank you for logging in with your social account. You may now use all the features of odesys.</h1>
    <div>
        <?php echo CHtml::link('create a new decision', array('/project/create/'), array('class'=>'decisionNew', 'title'=>'create a new decision')); ?>
    </div>
</section>
<section class="accounts">
    <div class="btcf">
        <h1 class="<?php echo $Services; ?>">Account management</h1>
        <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'login/index')); ?>
        <?php echo CHtml::link('delete my account', array('/user/delete/'), array('id'=>'deleteUser', 'title'=>'delete my account')); ?>
    </div>
</section>

<?php if(!empty($Decisions)) { ?>
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

            <?php foreach($Decisions as $D) { ?>
                <tr id="<?php echo $D->decision_id; ?>">
                    <td<?php echo ($D->getActiveDecisionModel()->evaluation_complete ? '' : ' class="alert"') ?>><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '.html'); ?><?php echo ($D->getActiveDecisionModel()->evaluation_complete ? '' : ' (decision model incomplete)') ?></td>
                    <td><?php if($D->isPrivate()) {
                        echo 'private';
                        } elseif ($D->isPublic()) {
                        echo 'public';
                        }?></td>
                    <td><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '/edit/', array('class'=>'edit')); ?></td>
                    <td><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '/delete/', array('class'=>'delete')); ?></td>
                </tr>
            <?php } ?>
        </table>
    </section>
<? } ?>
