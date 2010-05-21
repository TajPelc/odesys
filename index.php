<?php
function dump($data = null)
{
    echo '<pre style="display: block; border: 2px solid gray; background-color:#fff; padding: 0px 10px 0px 10px; margin: 10px;"';
    var_dump($data);
    echo '</pre>';
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
