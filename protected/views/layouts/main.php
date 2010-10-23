<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie8.css" />
    <![endif]-->

    <!-- JavaScript -->
    <?php if('results/display' == $this->getRoute() ) { ?><!--[if IE]><script language="javascript" type="text/javascript" src="/js/jqplot/excanvas.js"></script><![endif]--><?php } ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <div class="container" id="page">
        <div id="header">
            <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            <?php $this->widget('application.components.Tabs'); ?>
        </div>
        <?php echo $content; ?>
        <div id="footer">
            <hr />
            Copyright &copy; <?php echo date('Y'); ?> by Taj Pelc.<br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
        </div>
    </div>
</body>
</html>