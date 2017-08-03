<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'database' => array(
		/**
		 * Database settings for log storage.
		 *
		 * string   group  configuation group name
		 * string   table  session table name
		 * columns  array  custom column names
		 */
		'group'   => 'admin',
		'table'   => 'log_crash',
		'columns' => array(
			'log_crash_id' => 'log_crash_id',
			'ip'           => 'ip',
			'hostname'     => 'hostname',
			'level'        => 'level',
			'file'         => 'file',
			'line'         => 'line',
			'message'      => 'message',
			'trace'        => 'trace',
			'create_time'  => 'create_time'
		),
	)
);
