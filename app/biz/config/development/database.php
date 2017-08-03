<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 数据库配置
 */
return array
(
	'admin' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => '127.0.0.1',
			'database'   => 'gaojie_admin',
			'username'   => 'root',
			'password'   => 'test',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
);
