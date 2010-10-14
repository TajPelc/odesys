<?php
function dump($data = null, $var_dump = true, $escape = false)
{
    echo '<pre style="display: block; border: 2px solid gray; background-color:#fff; padding: 0px 10px 0px 10px; margin: 10px;">';
    if($var_dump)
    {
        var_dump($escape ? htmlspecialchars($data) : $data);
    }
    else
    {
        print_r($escape ? htmlspecialchars($data) : $data);
    }
    echo '</pre>';
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yiiframework/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
