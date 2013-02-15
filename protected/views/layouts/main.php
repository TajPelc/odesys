<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="language" content="en" />
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

    <!-- CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/layout.css" />

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/core/ie/layout.css" media="screen, projection" />
    <![endif]-->

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

<?php echo $content; ?>

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