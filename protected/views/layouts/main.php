<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <!-- JavaScript -->
    <?php if('results/display' == $this->getRoute() ) { ?><!--[if IE]><script language="javascript" type="text/javascript" src="/js/jqplot/excanvas.js"></script><![endif]--><?php } ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page">
    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	    <div id="mainmenu">
	        <?php $this->widget('zii.widgets.CMenu',array(
	            'items'=>array(
	                array('label' => 'Home',                                'url'=>array('/site/index')),
	                array('label' => 'Create a new project',                'url'=>array('/project/create', 'createNew' => 1),  'visible' => !Project::isProjectActive()),
	                array('label' => 'Project',                     'url'=>array('/project/create'),                    'visible' => Project::isProjectActive(), 'active' => true),
	                array('label' => 'My projects',                         'url'=>array('/project/index'),                     'visible' => !Yii::app()->user->isGuest),
	                array('label' => 'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'),                       'visible' => !Yii::app()->user->isGuest),
	                array('label' => 'Login',                               'url'=>array('/site/login'),                        'visible' => Yii::app()->user->isGuest),
	            ),
	        )); ?>
	    </div>
    </div>

    <?php echo $content; ?>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by Taj Pelc.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div>
</div>

</body>
</html>