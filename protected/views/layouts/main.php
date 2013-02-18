<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="language" content="en" />
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

        <!-- CSS Core -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/reset.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/layout.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/auth.css" />

        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/ie/layout.css" media="screen, projection" />
        <![endif]-->

        <!-- JavaScript Core -->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/jquery-ui-1.8.2.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/index.js"></script>

        <!-- Additional Includes -->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div id="wrapper">

            <div id="main">
                <header class="content">
                    <section>
                        <nav class="btcf">
                            <?php echo CHtml::link('odesys // helping you decide', array('/site/index/'), array('title'=>'odesys // helping you decide')); ?>
                            <?php if(Yii::app()->user->isGuest) { ?>
                                <ul>
                                    <li><?php echo CHtml::link('login', array('/login/'), array('class'=>'loginNew', 'title'=>'login')); ?></li>
                                </ul>
                            <?php } else { ?>
                                <ul>
                                    <li><?php echo CHtml::link('new decision', array('/project/create'), array('title' => 'Create a new decision', 'class' => 'decisionNew')); ?> <span>/</span></li>
                                    <li><?php echo CHtml::link('profile', array('/user/profile'), array('title' => 'Your profile')); ?> <span>/</span></li>
                                    <li><?php echo CHtml::link('log out', array('/login/logout')); ?></li>
                                </ul>
                                <p>Logged in as <?php echo Yii::app()->user->name; ?></p>
                            <?php } ?>
                        </nav>
                    </section>
                    <div id="banner"><div></div></div>
                </header>

                <?php echo $content; ?>
            </div>

        </div>
        <footer>
            <nav>
                <ul class="btcf">
                    <li><?php echo CHtml::link('about us', array('/site/about/'), array('title'=>'about us')); ?> / </li>
                    <li><?php echo CHtml::link('terms & conditions', array('/site/terms/'), array('title'=>'terms & conditions')); ?> / </li>
                    <li><?php echo CHtml::link('contact', array('/site/contact/'), array('title'=>'contact')); ?></li>
                </ul>
            </nav>
        </footer>

        <!-- DEBUGGER -->
        <?php if(YII_DEBUG) { ?>
            <?php if(0 !== $miliSleepTime = Yii::app()->params['miliSleepTime']) { ?>
                <div class="debug"><b>Warning!</b> Slow loading enabled, script execution delayed by <em><?php echo $miliSleepTime; ?>ms</em>.</div>
            <?php }?>
        <?php }?>

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
    </body>
</html>