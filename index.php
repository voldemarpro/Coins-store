<?php
// change the following paths if necessary
$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 5);

defined('JSON_FORCE_OBJECT') or define('JSON_FORCE_OBJECT', true);
if (!function_exists('json_encode')) {
	function json_encode($data, $json_force_object = false) {
		$json = array();
		$jsonReplaces = array (
			array("\\", "/", "\r\n", "\n", "\t", "\r", "\b", '"'),
			array('\\\\', '\\/', '\\r\\n', '\\n', '\\t', '\\r', '\\b', '\"')
		);
		if (!$json_force_object)
			$is_numeric = (!is_object($data)) ? is_int(key($data)) : false;
		else
			$is_numeric = false; 
		foreach ($data as $key=>$value) {
			if(!is_array($value) && !is_object($value)) {
				$value = (is_int($value)) ? $value : '"'.str_replace($jsonReplaces[0], $jsonReplaces[1], $value).'"';
				$json[] = $is_numeric ? $value : '"'.$key.'":'.$value;
			}
			else
				$json[] = $is_numeric ? json_encode($value, $json_force_object) : '"'.$key.'":'.json_encode($value, $json_force_object);
		}
		return ($is_numeric) ? '['.implode($json, ', ').']' : '{'.implode($json, ', ').'}';
	}
}

require $yii;

mb_internal_encoding('utf-8');
Yii::createWebApplication($config)->run();
