<?php
/**
 * 权限/角色关系业务逻辑层
 */
class Business_Role_Privilege extends Business {

	/**
	 * 插入关系
	 * @param  array $values
	 * @return array
	 */
	public function create($values) {
		$fields = array(
			'privilege_id' => 0,
			'role_id' => 0,
			'create_time' => time()
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Role_Privilege')->insert($values);
	}

	/**
	 * 根据privilegeId删除记录
	 * @param  integer $privilegeId 权限ID
	 * @return boolean|integer 删除的记录数
	 */
	public function deleteByPrivilegeId($privilegeId) {
		if (!Valid::not_empty($privilegeId)) {
			return false;
		}
		return Dao::factory('Role_Privilege')->deleteByPrivilegeId($privilegeId);
	}

	/**
	 * 根据主键ID删除记录
	 * @param  array $rolePrivilegeIds 主键id
	 * @return boolean | integer 删除的记录数
	 */
	public function deleteByRolePrivilegeIds($rolePrivilegeIds) {
		if (!Valid::not_empty($rolePrivilegeIds)) {
			return false;
		}
		return Dao::factory('Role_Privilege')->deleteByRolePrivilegeIds($rolePrivilegeIds);
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
		return Dao::factory('Role_Privilege')->deleteByRoleId($roleId);
	}

	/**
	 * 根据权限ID获取记录
	 * @param  integer $privilegeId 权限ID
	 * @return array
	 */
	public function getAllByPrivilegeId($privilegeId = 0) {
		if (!Valid::not_empty($privilegeId)) {
			return array();
		}
		return Dao::factory('Role_Privilege')->getAllByPrivilegeId($privilegeId);
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
		return Dao::factory('Role_Privilege')->getAllByRoleId($roleId);
	}

	/**
	 * 根据角色Id和权限ID获取记录
	 * @param  integer $roleId       角色id
	 * @param  array   $privilegeIds 权限id
	 * @return array
	 */
	public function getAllByRoleIdAndPrivilegeIds($roleId = 0, $privilegeIds = array()) {
		if (!Valid::not_empty($roleId) || !Valid::not_empty($privilegeIds)) {
			return array();
		}
		return Dao::factory('Role_Privilege')->getAllByRoleIdAndPrivilegeIds($roleId, $privilegeIds);
	}
}
