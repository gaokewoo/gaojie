<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller {
	
	static public $errors = array(
		'403' => '服务器拒绝访问',
		'404' => '页面不存在',
		'405' => '无权访问',
		'500' => '系统故障',
	);
	
	public function action_index() {
		$code = intval($_SERVER['QUERY_STRING']);
		$error = '';

		if(!in_array($code, array_keys(self::$errors))) {
			$code = '500';
		}
		if(isset(self::$errors[$code])) {
			$error = self::$errors[$code];
		}

		$layout = View::factory('layouts/error');
		$layout->content = View::factory('error/'.$code)->set('error', $error);
		$this->response->body($layout->render());
	}
}
