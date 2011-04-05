<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'ODESYS Alpha: The on-line decision support system',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',
    ),

    // application components
    'components'=>array(
	// login component
        'user'=>array(
            'allowAutoLogin'=>true,
        ),
        // database configuration
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=databasenamehere',
            'emulatePrepare' => true,
            'username' => 'usernamehere',
            'password' => 'passwordhere',
            'charset' => 'utf8',
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

        // testing/debug params
        'miliSleepTime' => 0,
    ),
);
