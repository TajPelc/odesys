<?php $this->pageTitle = Yii::app()->name . ' / Login'; ?>
<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableAjaxValidation'=>true,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Login'); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php if(Yii::app()->user->isGuest){ ?>
    <div class="facebook-login">
        <div class="login_sector_fb">
            <h2>Login</h2>
            <div class="login_prompt">Or <b>login</b> with Facebook:</div>
            <fb:login-button></fb:login-button>
        </div>
        <div>
            <h2>Logout</h2>
            <?php // CHtml::link('Logout('.Yii::app()->user->name.')', Yii::app()->user->logoutUrl)?>
        </div>
    </div>
<?php } ?>
<div class="clear"></div>
<?php
$login_url = 'http://'.$_SERVER['HTTP_HOST'].Yii::app()->request->baseUrl.'/user/login/facebook/';
Yii::app()->clientScript->registerScript(
   'facebook_onligin_ready',
   'function facebook_onlogin_ready() {
        window.location = "'.$login_url.'";
    }',
   CClientScript::POS_END
);
?>
