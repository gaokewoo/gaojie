<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 管理员角色业务逻辑层
 */
class Business_Role extends Business {

	/**
	 * 创建角色
	 * @param array $values
	 * @return boolean
	 */
	public function create(array $values){
		$fields = array (
			'name' => '',
			'create_time' => time(),
			'update_time' => time()
		);

		$name = Arr::get($values,'name');
		$errors = array();
		if(!$name) {
			$errors[] = '角色名称不能为空！';
		}
		if($errors) {
			throw new Business_Exception(implode(' ', $errors));
		}

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Role')->insert($values);
	}

	/**
	 * 根据角色ID更新角色信息
	 * @param  integer $roleId 角色ID
	 * @param  array   $values 要更新的角色信息
	 * @return boolean
	 */
	public function updateByRoleId($roleId, $values) {
		$errors = array();
		if (!$roleId || !$values) {
			$errors[] = '参数不正确！';
		}
		$fields = array (
			'name' => '',
			'update_time' => time()
		);
		$values = array_intersect_key($values, $fields);
		if (count($values) < 1) {
			$errors[] = '没有要被更新的字段';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		$values = $values + $fields;

		return Dao::factory('Role')->updateByRoleId($roleId, $values);
	}

	/**
	 * 根据角色ID删除角色
	 * @param  integer $roleId 角色ID
	 * @return boolean
	 */
	public function deleteByRoleId($roleId) {
		$errors = array();
		if (!$roleId) {
			$errors[] = '参数不正确！';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		// 删除角色
		$result = Dao::factory('Role')->deleteByRoleId($roleId);
		if (!Valid::not_empty($result)) {
			throw new Business_Exception('删除角色记录失败！');
		}
		// 删除角色/用户关系
		$result = Dao::factory('Role_Manager')->deleteByRoleId($roleId);
		if (!Valid::not_empty($result)) {
			throw new Business_Exception('删除角色/用户关系记录失败！');
		}
		// 删除角色/权限关系
		$result = Dao::factory('Role_Privilege')->deleteByRoleId($roleId);
		if (!Valid::not_empty($result)) {
			throw new Business_Exception('删除角色/权限关系记录失败！');
		}

		return true;
	}

	/**
	 * 根据角色ID删除角色
	 * @param  array $roleIds 角色ID
	 * @return boolean
	 */
	public function deleteByRoleIds($roleIds) {
		$errors = array();
		if (!$roleIds) {
			$errors[] = '参数不正确！';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		// 删除角色
		$result = Dao::factory('Role')->deleteByRoleIds($roleIds);
		if (!Valid::not_empty($result)) {
			throw new Business_Exception('删除角色记录失败！');
		}
		// 删除角色/用户关系
		$result = Dao::factory('Role_Manager')->deleteByRoleIds($roleIds);
		if (!Valid::not_empty($result)) {
			throw new Business_Exception('删除角色/用户关系记录失败！');
		}
		// 删除角色/权限关系
		$result = Dao::factory('Role_Privilege')->deleteByRoleIds($roleIds);
		if (!Valid::not_empty($result)) {
			throw new Business_Exception('删除角色/权限关系记录失败！');
		}

		return true;
	}

	/**
	 * 获取所有角色
	 * @return array
	 */
	public function getRoles() {
		return Dao::factory('Role')->getRoles();
	}

	/**
	 * 根据角色ID获取角色
	 * @param  integer $roleId 角色ID
	 * @return array
	 */
	public function getRoleByRoleId($roleId) {
		if (!$roleId) {
			return array();
		}
		return Dao::factory('Role')->getRoleByRoleId($roleId);
	}
}
