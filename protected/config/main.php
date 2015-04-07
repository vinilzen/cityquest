<?php

$local_config = require(dirname(__FILE__).'/local.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CityQuest',

    'language' => 'ru',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.Facebook.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
	),

    'modules'=>array(
        'user',
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'zaq1',
        ),
    ),

	'defaultController'=>'quest',

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
			'loginUrl' => array('/user/login'),
		),

		'Facebook'=>array(
			'class' => 'application.components.Facebook'
		),

		'db'=>$local_config['db'],
		
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'rules'=>'site/about',
				'<lang:kz|ru>'=>'site/lang',
				'giftcard'=>'site/giftcard',
				'franchise'=>'site/franchise',
				'press_about_us'=>'site/press',
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
				array(
					'class' => 'application.extensions.ExtendedLogger.ExtendedLogger',
					'levels'=>'profile',
					'logFile'=>'profile.log',
				),
		        /*array(
			    	'class'=>'CWebLogRoute',
			        'levels'=>'error, warning, trace, log, vardump',
		        ),*/
			),
		),
	),
	'params'=>require(dirname(__FILE__).'/params.php'),
);