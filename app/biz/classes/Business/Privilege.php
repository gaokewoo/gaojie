<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 权限业务逻辑层
 */
class Business_Privilege extends Business {

	/**
	 * 添加权限
	 * @param  array  $value 
	 * @return array
	 */
	public function create($values = array ()) {

		$fields = array (
			'name' => '',
			'parent_id' => 0,
			'path' => '',
			'module_id' => 0,
			'domain' => '',
			'portal' => '',
			'module' => '',
			'controller' => '',
			'action' => '',
			'target' => '',
			'icon' => '',
			'type' => Model_Privilege::TYPE_CONTROLLER,
			'is_display' => Model_Privilege::IS_DISPLAY,
			'sequence' => 0,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Privilege')->insert($values);
	}

	/**
	 * 根据权限ID更新记录
	 * @param  integer $privilegeId 权限ID
	 * @param  array   $values      要更新的记录值
	 * @return integer
	 */
	public function updateByPrivilegeId($privilegeId, $values) {
		$errors = array();
		if (!$privilegeId || !$values) {
			$errors[] = '参数不正确！';
		}
		$fields = array (
			'name' => '',
			'parent_id' => 0,
			'path' => '',
			'module_id' => 0,
			'domain' => '',
			'portal' => '',
			'module' => '',
			'controller' => '',
			'action' => '',
			'target' => '',
			'icon' => '',
			'type' => Model_Privilege::TYPE_CONTROLLER,
			'is_display' => Model_Privilege::IS_DISPLAY,
			'sequence' => 0,
			'create_time' => time(),
			'update_time' => time(),
		);
		$values = array_intersect_key($values, $fields);
		if (count($values) < 1) {
			$errors[] = '没有要被更新的字段';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		return Dao::factory('Privilege')->updateByPrivilegeId($privilegeId, $values);
	}

	/**
	 * 更新后辈节点路径
	 * @param  string $oldPath 老路径
	 * @param  string $newPath 新路径
	 * @return boolean
	 */
	public function updateDescendantNode($oldPath, $newPath) {
		if (!Valid::not_empty($oldPath) || !Valid::not_empty($newPath)) {
			return false;
		}
		return Dao::factory('Privilege')->updateDescendantNode($oldPath, $newPath);
	}

	/**
	 * 根据权限ID查找权限
	 * @param  integer $privilegeId 权限ID
	 * @return array
	 */
	public function getPrivilegeByPrivilegeId($privilegeId) {
		if (!Valid::not_empty($privilegeId)) {
			return array();
		}
		return Dao::factory('Privilege')->getPrivilegeByPrivilegeId($privilegeId);
	}

	/**
	 * 获取深度为$depth或小于$depth的权限
	 * @param  integer $depth 深度
	 * @return array
	 */
	public function getPrivilegesByDepth($depth = 0) {
		if ($depth == 0) {
			return Dao::factory('Privilege')->getAllPrivileges();
		} else {
			return Dao::factory('Privilege')->getPrivilegesByDepth($depth);
		}
	}

	/**
	 * 获取所有权限
	 * @return array
	 */
	public function getAllPrivileges() {
		return Dao::factory('Privilege')->getAllPrivileges();
	}

	/**
	 * 获取所有类型为菜单的权限
	 * @return array
	 */
	public function getMenus() {
		return Dao::factory('Privilege')->getPrivilegesByType('menu');
	}

	/**
	 * 获取所有类型为控制器的权限
	 * @return array
	 */
	public function getControllers() {
		return Dao::factory('Privilege')->getPrivilegesByType('controller');
	}

	/**
	 * 根据路径删除权限
	 * @param  string $path 路径
	 * @return boolean
	 */
	public function deleteByPath($path) {
		if (!Valid::not_empty($path)) {
			return false;
		}
		return Dao::factory('Privilege')->deleteByPath($path);
	}

}
