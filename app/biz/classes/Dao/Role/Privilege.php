<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 权限ID和角色关系映射Dao层
 */
class Dao_Role_Privilege extends Dao {

	protected $_db = 'admin';
	
	protected $_tableName = 'role_privilege';
	
	protected $_primaryKey = 'role_privilege_id';

	/**
	 * 根据权限Ids获取权限ID和角色关系映射
	 * @param  array $privilegeIds 权限IDs
	 * @return array
	 */
	public function getAllByPrivilegeIds($privilegeIds) {
		$query = DB::select()
			->from($this->_tableName)
			->where('privilege_id', 'IN', $privilegeIds);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据权限Ids获取权限ID和角色关系映射
	 * @param  integer $privilegeId 权限ID
	 * @return array
	 */
	public function getAllByPrivilegeId($privilegeId) {
		$query = DB::select()
			->from($this->_tableName)
			->where('privilege_id', '=', $privilegeId);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据角色ID获取记录
	 * @param  integer $roleId 角色ID
	 * @return array
	 */
	public function getAllByRoleId($roleId = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->where('role_id', '=', $roleId);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据角色ID获取记录
	 * @param  array $roleIds 角色ID
	 * @return array
	 */
	public function getAllByRoleIds($roleIds = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->where('role_id', 'IN', $roleIds);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 插入一条
	 * @param  array  $values
	 * @return integer
	 */
	public function insert(array $values) {
		return DB::insert($this->_tableName)
			->columns(array_keys($values))
			->values(array_values($values))
			->execute($this->_db);
	}

	/**
	 * 根据privilegeId删除记录
	 * @param  integer $privilegeId 权限ID
	 * @return boolean
	 */
	public function deleteByPrivilegeId($privilegeId) {
		return DB::delete($this->_tableName)
			->where('privilege_id', '=', $privilegeId)
			->execute($this->_db);
	}

	/**
	 * 根据roleId删除记录
	 * @param  integer $roleId 角色ID
	 * @return boolean|integer 删除的记录数
	 */
	public function deleteByRoleId($roleId) {
		return DB::delete($this->_tableName)
			->where('role_id', '=', $roleId)
			->execute($this->_db);
	}

	/**
	 * 根据roleId删除记录
	 * @param  array $roleIds 角色ID
	 * @return boolean|integer 删除的记录数
	 */
	public function deleteByRoleIds($roleIds) {
		return DB::delete($this->_tableName)
			->where('role_id', 'IN', $roleIds)
			->execute($this->_db);
	}

	/**
	 * 根据主键ID删除记录
	 * @param  array $rolePrivilegeIds 主键id
	 * @return boolean | integer 删除的记录数
	 */
	public function deleteByRolePrivilegeIds($rolePrivilegeIds) {
		return DB::delete($this->_tableName)
			->where($this->_primaryKey, 'IN', $rolePrivilegeIds)
			->execute($this->_db);
	}

	/**
	 * 根据角色Id和权限ID获取记录
	 * @param  integer $roleId       角色id
	 * @param  array   $privilegeIds 权限id
	 * @return array
	 */
	public function getAllByRoleIdAndPrivilegeIds($roleId = 0, $privilegeIds = array()) {
		$query = DB::select()
			->from($this->_tableName)
			->where('role_id', '=', $roleId)
			->where('privilege_id', 'IN', $privilegeIds);

		return $query->execute($this->_db)->as_array();
	}

}
