<?php

$local_config = require(dirname(__FILE__).'/local.php');
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	'components'=>array(
		'db'=>$local_config['db'],
	),
	'import'=>array(
		'ext.YiiMailer.YiiMailer'
	),
	'params'=>require(dirname(__FILE__).'/params.php'),
);