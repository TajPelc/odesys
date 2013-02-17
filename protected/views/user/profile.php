<?php $this->pageTitle='Profile | Decision feed'; ?>
<section class="content">
    <h1>Welcome <b>Frenk Ten</b>, thank you for logging in with your social account. You may now use all the features of odesys.</h1>
    <div>
        <?php echo CHtml::link('create a new decision', array('/site/login/'), array('class'=>'projectNew', 'title'=>'create a new decision')); ?>
    </div>
</section>
<section class="accounts">
    <div class="btcf">
        <h1>Account management</h1>
        <?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login')); ?>
        <?php echo CHtml::link('delete my account', array('/'), array('id'=>'delete', 'title'=>'delete my account')); ?>
    </div>
</section>
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
