<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ACL(Access Control List)
 */
class ACL {

	static protected $_instance = null;

	public static function instance() {
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// 白名单
	protected static $_whiteList = array(
		'dashboard_index' => '首页',
		'main_index' => '首页',
		'default_index' => '登录页',
		'default_login' => '登录验证',
		'default_logout' => '注销登录',
		'default_register' => '申请登录权限',
		'manager_profileinfo' => '个人资料',
		'manager_profileedit' => '个人设置',
		'manager_profilemodify' => '个人设置保存',
	);

	protected function __construct() { }

	public static function access($controller, $action = null)
	{
        // 超级管理员root，具备所有权限
        if (Manager::managerId() == 1) {
            return true;
        }

		$domains = array($_SERVER['SERVER_NAME'], $_SERVER['HTTP_HOST']);
		$controller = strtolower($controller);
		$action = strtolower($action);
		
		if (array_key_exists($controller.'_'.$action, self::$_whiteList)) return true;

		$privileges = Manager::privileges();
		foreach($privileges as $privilege) {
			if(PORTAL == $privilege->getPortal()
				&& $controller == strtolower($privilege->getController())
				&& $action == strtolower($privilege->getAction())) {
				return true;
			}
		}
		
		return false;
	}

}
