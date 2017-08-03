<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 角色 Dao 层
 */
class Dao_Role extends Dao {

	protected $_db = 'admin';
	
	protected $_tableName = 'role';
	
	protected $_primaryKey = 'role_id';

	/**
	 * 创建角色
	 * @param  array $values 
	 * @return boolean
	 */
	public function insert($values) {
		return DB::insert($this->_tableName)
			->columns(array_keys($values))
			->values(array_values($values))
			->execute($this->_db);
	}

	/**
	 * 根据角色ID更新角色信息
	 * @param  integer $roleId 角色ID
	 * @param  array   $values 要更新的角色信息
	 * @return array
	 */
	public function updateByRoleId($roleId, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $roleId);

		return $query->execute($this->_db);
	}

	/**
	 * 根据角色ID删除角色
	 * @param  integer $roleId 角色ID
	 * @return boolean
	 */
	public function deleteByRoleId($roleId) {
		$query = DB::delete($this->_tableName)
			->where($this->_primaryKey, '=', $roleId);

		return $query->execute($this->_db);
	}

	/**
	 * 根据角色ID删除角色
	 * @param  array $roleIds 角色ID
	 * @return boolean
	 */
	public function deleteByRoleIds($roleIds) {
		$query = DB::delete($this->_tableName)
			->where($this->_primaryKey, 'IN', $roleIds);

		return $query->execute($this->_db);
	}

	/**
	 * 获取角色
	 * @return array
	 */
	public function getRoles() {
		$query = DB::select()
			->from($this->_tableName);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据角色ID获取角色
	 * @param  integer $roleId 角色ID
	 * @return array
	 */
	public function getRoleByRoleId($roleId) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $roleId);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据角色ID获取角色信息
	 * @param  array $roleIds 角色ID
	 * @return array
	 */
	public function getRolesByRoleIds($roleIds) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, 'IN', $roleIds);

		return $query->execute($this->_db)->as_array();
	}
}
