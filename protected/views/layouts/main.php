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
    <div id="fb-root"></div>
    <div id="wrapper">
        <div id="header">
            <div id="headings">
                <?php if((bool)$this->customHeader){ ?>
                    <h1><?php echo CHtml::link(CHtml::encode(Yii::app()->name), array('/site/index')); ?><span><?php echo $this->customHeader; ?></span></h1>
                <?php } else { ?>
                    <h1><?php echo CHtml::link(CHtml::encode(Yii::app()->name), array('/site/index')); ?><span>Decision Support</span></h1>
                <?php }?>
            </div>
            <div id="login">
                <?php if(Yii::app()->user->isGuest){ ?>
                    <?php CHtml::link(CHtml::image('http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif', 'Facbook Connect'), array('/login/facebook'), array('id' => 'facebookLogin')); ?>
                <?php } else { ?>
                    <div id="login_image"><?php // echo CHtml::image('https://graph.facebook.com/' . Yii::app()->user->facebook_id . '/picture');?></div>
                        <div>
                            <h2>Welcome, <i><?php echo Yii::app()->user->name; ?></i>!</h2>
                            <ul>
                                <li><?php echo CHtml::link('New', array('/project/create'), array('title' => 'Start a new decision', 'class' => 'projectNew')); ?></li>
                                <li><?php echo CHtml::link('Profile', array('/user/notifications'), array('title' => 'View your decision feed and your decisions')); ?></li>
                                <li><?php echo CHtml::link('Logout', array('/login/logout')); ?></li>
                            </ul>
                        </div>
                <?php }?>
            </div>
        </div>
        <?php echo $content; ?>
        <div id="push"></div>
    </div>
    <div id="footer">
        <ul>
            <li>
                <dl>
                    <dt><?php echo CHtml::link('About', array('/site/about')); ?></dt>
                    <dd>
                        <p>Making decisions is tough. But we are here to help.</p>
                        <p>Our application will guide you through the decision-making process. We provide the tool you need to analyse your alternatives and weigh your options. The decision is then up to you.</p>
                        <p>By utilizing the power of our visual engine and by enlisting help from the people you trust the quality of your decisions is sure to improve.</p>
                    </dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt><?php echo CHtml::link('Contact', array('/site/contact')); ?></dt>
                    <dd>
                        <a id="footer_facebook" href="https://www.facebook.com/odesys">facebook<span>ODESYS</span></a>
                        <a id="footer_twitter" href="https://twitter.com/#!/ODESYSinfo">twitter<span>@ODESYSinfo</span></a>
                        <?php if(Yii::app()->user->isGuest){ ?>
                            <?php echo CHtml::link('email<span>odesys.info</span>', array('/site/contact'), array('id' => 'footer_email')); ?>
                        <?php } else { ?>
                           <a id="footer_email" href="mailto:info@odesys.info">email<span>info@odesys.info</span></a>
                        <?php }?>
                    </dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt><?php echo CHtml::link('Terms', array('/site/terms')); ?></dt>
                    <dd>
                        <p>Before using this service you must agree to the <?php echo CHtml::link('following terms', array('/site/terms')); ?>.</p>
                        <p>We provide the tools to help. You are the one that makes the decision, therefore we cannot be responsible for the consequences of your actions.</p>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
    <?php if(YII_DEBUG) { ?>
        <?php if(0 !== $miliSleepTime = Yii::app()->params['miliSleepTime']) { ?>
            <div class="debug"><b>Warning!</b> Slow loading enabled, script execution delayed by <em><?php echo $miliSleepTime; ?>ms</em>.</div>
        <?php }?>
    <?php }?>
</body>
</html>