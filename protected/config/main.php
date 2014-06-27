<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CityQuest',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
	),

    'modules'=>array(
        'user',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'zaq',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.126.1','::1'),
		),
    ),

	'defaultController'=>'quest',

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl' => array('/user/login'),
		),



		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=cityquest',
			'emulatePrepare' => true,
    		'enableParamLogging' => true,
			'username' => 'cityquest',
			'password' => 'cityquest123',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
			// 	array(
			// 		'class'=>'CFileLogRoute',
			// 		'levels'=>'trace, info, error, warning, vardump',
			// 	),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, info, error, warning, vardump',
					'showInFireBug'=>true,
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);