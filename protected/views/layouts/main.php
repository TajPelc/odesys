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
                    <h2>Now deciding on "<?php echo Project::getActive()->title; ?>"</h2>
                <?php } else { ?>
                    <h2>Helping you decide!</h2>
                <?php }?>
            </div>
            <div id="login">
                <?php if(Yii::app()->user->isGuest){ ?>
                    <?php echo CHtml::link(CHtml::image('http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif', 'Facbook Connect'), array('login/facebook')); ?>
                <?php } else { ?>
                    <div id="login_image"><?php echo CHtml::image('https://graph.facebook.com/' . Yii::app()->user->id . '/picture');?></div>
                        <div>
                            <h2>Welcome, <i><?php echo Yii::app()->user->data['name']; ?></i>!</h2>
                            <ul>
                                <li><?php echo CHtml::link('Dashboard', array('criteria/create')); ?></li>
                                <li><?php echo CHtml::link('New decision!', array('criteria/create')); ?></li>
                                <li><?php echo CHtml::link('Logout', array('criteria/create')); ?></li>
                            </ul>
                        </div>
                <?php }?>
            </div>
        </div>
        <?php echo $content; ?>
        <div id="footer">
            <ul>
                <li><?php echo CHtml::link('About', array('/site/about')); ?></li>
                <li><a href="#">Terms of use</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
</body>
</html>