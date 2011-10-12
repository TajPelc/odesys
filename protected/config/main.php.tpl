<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'ODESYS 2.0: The on-line decision support system',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.models.notification.*',
        'application.components.*',
        'application.helpers.*',
    ),

    // modules
    'modules'=>array(
        'decision',
        'gii'=>array( // gii tool
            'class'=>'system.gii.GiiModule',
            'ipFilters'=> array('localhost', '127.0.0.1', '192.168.15.148'),
            'password'=>'wtf',
        ),
    ),

    // application components
    'components'=>array(

        // user
        'user'=>array(
          'allowAutoLogin'=>true,
        ),

        // url manager
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array_merge(
                array(
                    '/' => 'site/index',
                    '<_c:(decision)>/<decisionId:\d+>-<label>/' => array('project/public', 'urlSuffix' => '.html'),
                ),
                require_once('protected/modules/decision/config/url-rules.php')
            ),
            'showScriptName'=>false,
            'urlSuffix' => '/',
        ),

        // database configuration
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=DBNAMEHERE',
            'emulatePrepare' => true,
            'username' => 'DBUSERNAME',
            'password' => 'DBPASSWORD',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
    // error handling
        'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
    // logging
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'trace, info, error, warning',
                ),
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
        // facebook settings
        'fbAppId' => '165209310185741',
        'fbAppSecret' => '8625578e976c2e457236a5cd1c0d3c79',

        // debuging / test
        'miliSleepTime' => 0,
    ),
);