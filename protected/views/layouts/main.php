<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

    <!-- CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/layout.css" />

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/ie/layout.css" media="screen, projection" />
    <![endif]-->

    <!-- JavaScript framework -->
    <?php if('results/display' == $this->getRoute() ) { ?><!--[if IE]><script language="javascript" type="text/javascript" src="/js/jqplot/excanvas.js"></script><![endif]--><?php } ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- Google Analytics -->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-19289535-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <div id="headings">
                <h1><?php echo CHtml::link(CHtml::encode(Yii::app()->name), array('/site/index')); ?></h1>
                <?php if(Project::isProjectActive()){ ?>
                    <h2>Now deciding on "<?php echo CHtml::link(CHtml::encode(Project::getActive()->title), array('criteria/create'));?>"</h2>
                <?php } else { ?>
                    <h2>Helping you decide!</h2>
                <?php }?>
            </div>
            <div id="login">
                <?php if(Yii::app()->user->isGuest){ ?>
                    <?php echo CHtml::link(CHtml::image('http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif', 'Facbook Connect'), array('login/facebook'), array('id' => 'facebookLogin')); ?>
                <?php } else { ?>
                    <div id="login_image"><?php echo CHtml::image('https://graph.facebook.com/' . Yii::app()->user->facebook_id . '/picture');?></div>
                        <div>
                            <h2>Welcome, <i><?php echo Yii::app()->user->data['name']; ?></i>!</h2>
                            <ul>
                                <li><?php echo CHtml::link('New decision', array('project/create'), array('title' => 'Start a new decision-making process!', 'class' => 'projectNew' . (Project::isProjectActive() ? ' active' : ''))); ?></li>
                                <li><?php echo CHtml::link('Dashboard', array('user/dashboard'), array('title' => 'View your dashboard. See previous decisions.')); ?></li>
                                <li><?php echo CHtml::link('Logout', array('login/logout')); ?></li>
                            </ul>
                        </div>
                <?php }?>
            </div>
        </div>
        <?php echo $content; ?>
        <div id="footer">
            <ul>
                <li><?php echo CHtml::link('About', array('/site/about')); ?></li>
                <li><?php echo CHtml::link('Terms of use', array('/site/terms')); ?></li>
                <li><?php echo CHtml::link('Contact', array('/site/contact')); ?></li>
            </ul>
        </div>
    </div>
    <?php if(YII_DEBUG) { ?>
        <?php if(0 !== $miliSleepTime = Yii::app()->params['miliSleepTime']) { ?>
            <div class="debug"><b>Warning!</b> Slow loading enabled, script execution delayed by <em><?php echo $miliSleepTime; ?>ms</em>.</div>
        <?php }?>
    <?php }?>
</body>
</html>