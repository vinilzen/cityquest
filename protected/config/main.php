<?php

$local_config = require(dirname(__FILE__).'/local.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CityQuest - Квесты «выберись из комнаты» ',

    'language' => 'ru',
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
		// 'gii'=>array(
		// 	'class'=>'system.gii.GiiModule',
		// 	'password'=>'zaq',
		// 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
		// 	'ipFilters'=>array('127.0.0.1','192.168.126.1','::1'),
		// ),
    ),

	'defaultController'=>'quest',

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl' => array('/user/login'),
		),

		'db'=>$local_config['db'],
		
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
				'rules'=>'site/about',
				'giftcard'=>'site/giftcard',
				'franchise'=>'site/franchise',
				'contact'=>'site/contact',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
				 		'class'=>'CFileLogRoute',
				 		'levels'=>'info',
				 		'logFile'=>'info.log',
				),
				/*array(
					'class'=>'CWebLogRoute',
					'levels'=>'trace, error, warning, vardump',
					'showInFireBug'=>true,
				),*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);