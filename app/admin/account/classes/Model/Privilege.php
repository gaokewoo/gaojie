<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 权限模型
 */
class Model_Privilege extends Model {

	/**
	 * 权限是否显示：显示
	 */
	const IS_DISPLAY = 1;

	/**
	 * 权限是否显示：不显示
	 */
	const NOT_DISPLAY = 0;

	/**
	 * 权限类型： 控制器
	 */
	const TYPE_CONTROLLER = 'controller';

	/**
	 * 权限类型： 菜单
	 */
	const TYPE_MENU = 'menu';

	/**
	 * 权限类型： 导航
	 */
	const TYPE_NAVIGATOR = 'navigator';
}
