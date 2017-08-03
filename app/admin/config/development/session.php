<?php defined('SYSPATH') OR die('No direct script access.');

return array(

	'cookie' => array(
		'encrypted' => FALSE,
	),

	'database' => array(
		'group' => 'admin',
		'table' => 'session',
		'gc' => 500,
		'columns' => array(
			'session_id' => 'session_id',
			'last_active' => 'last_active',
			'contents' => 'contents',
		),
	),
);
