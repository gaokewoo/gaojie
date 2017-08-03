<?php
/**
 * 管理员/角色关系业务逻辑层
 */
class Business_Role_Manager extends Business {

	/**
	 * 插入关系
	 * @param  array $values
	 * @return array
	 */
	public function create($values) {
		$fields = array(
			'manager_id' => 0,
			'role_id' => 0,
			'create_time' => time()
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Role_Manager')->insert($values);
	}

	/**
	 * 根据ManagerId删除记录
	 * @param  integer $managerId 用户ID
	 * @return boolean|integer 删除的记录数
	 */
	public function deleteByManagerId($managerId) {
		if (!Valid::not_empty($managerId)) {
			return false;
		}
		return Dao::factory('Role_Manager')->deleteByManagerId($managerId);
	}

	/**
	 * 根据roleId删除记录
	 * @param  integer $roleId 角色ID
	 * @return boolean|integer 删除的记录数
	 */
	public function deleteByRoleId($roleId) {
		if (!Valid::not_empty($roleId)) {
			return false;
		}
		return Dao::factory('Role_Manager')->deleteByRoleId($roleId);
	}

	/**
	 * 根据管理员ID获取记录
	 * @param  integer $managerId 管理员ID
	 * @return array
	 */
	public function getAllByManagerId($managerId = 0) {
		if (!Valid::not_empty($managerId)) {
			return array();
		}
		return Dao::factory('Role_Manager')->getAllByManagerId($managerId);
	}

	/**
	 * 根据角色ID获取记录
	 * @param  integer $roleId 角色ID
	 * @return array
	 */
	public function getAllByRoleId($roleId = 0) {
		if (!Valid::not_empty($roleId)) {
			return array();
		}
		return Dao::factory('Role_Manager')->getAllByRoleId($roleId);
	}
}
