<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	
	'name'=>'Coins Store',
	
	'defaultController' => 'home',
	
	'charset' => 'UTF-8',

	'language' => 'en',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.components.*',
		'application.models.*',
		'application.helpers.*'
	),

	'modules'=>array(
			'adm'=>array(
				// autoloading component classes
				'import'=>array(
					'adm.components.*'
				),
				
				'components'=>array(
					'user'=>array(
						'class' => 'WebAdmin',
						'loginUrl'=>'/login',
						'allowAutoLogin'=>false
					)
				)
			)
	
		),

	// application components
	'components'=>array(
		
		'assetManager' => array(
			'forceCopy' => false,
			'excludeFiles' =>array('.css')
		),
		
		'clientScript' => array(
			'enableJavaScript' => true,
			'coreScriptPosition' => 1,
			'scriptMap' => array('jquery.js' => false)
		),
	 
		'authManager' => array(
			'class' => 'PhpAuthManager',
			'defaultRoles' => array('guest')
		),
		
		'user'=>array(
			'class' => 'WebUser',
			'loginUrl'=>false,
			// enable cookie-based authentication
			'allowAutoLogin'=>false
		),
		
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			/*'caseSensitive'=>false,*/
			'rules'=>array(
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:adm>'=>'<module>/packages',				
				'<module:adm>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>/id/<id>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>/id/<id>',
				'<action:(login|logout)>'=>'auth/<action>'
			),
			'showScriptName'=>false,
		),
		
		// uncomment the following to use a MySQL database
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=xsolla',
			'emulatePrepare' => false,
			'autoConnect' => false,
			'username' => 'root',
			'password' => 'cheburashka',
			'charset' => 'utf8',
			'tablePrefix'=>'bill_'
		),

		'errorHandler'=>array(
			'errorAction'=>'home/error',
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				)
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);