<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理员ID和角色关系映射Dao层
 */
class Dao_Role_Manager extends Dao {

	protected $_db = 'admin';
	
	protected $_tableName = 'role_manager';
	
	protected $_primaryKey = 'role_manager_id';

	/**
	 * 根据管理员Ids获取管理员ID和角色关系映射
	 * @param  array $managerIds 管理员IDs
	 * @return array
	 */
	public function getAllByManagerIds($managerIds) {
		$query = DB::select()
			->from($this->_tableName)
			->where('manager_id', 'IN', $managerIds);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据管理员Id获取管理员Id和角色关系映射
	 * @param  integer $managerId 管理员ID
	 * @return array
	 */
	public function getAllByManagerId($managerId) {
		$query = DB::select()
			->from($this->_tableName)
			->where('manager_id', '=', $managerId);

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
	 * 根据ManagerId删除记录
	 * @param  integer $managerId 用户ID
	 * @return boolean
	 */
	public function deleteByManagerId($managerId) {
		return DB::delete($this->_tableName)
			->where('manager_id', '=', $managerId)
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
}
