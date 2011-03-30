<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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
            <h1><?php echo CHtml::link(CHtml::encode(Yii::app()->name), array('/site/index')); ?></h1>
            <div id="login"><a href="#">Login with Facebook</a></div>
        </div>
        <?php echo $content; ?>
        <div id="footer">
            <ul>
                <li><?php echo CHtml::link('About', array('/site/about')); ?></li>
                <li><a href="#">Terms of use</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <div>
                <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fodesys&amp;layout=standard&amp;show_faces=false&amp;width=225&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=28" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:225px; height:28px;" allowTransparency="true"></iframe>
            </div>
        </div>
    </div>
</body>
</html>