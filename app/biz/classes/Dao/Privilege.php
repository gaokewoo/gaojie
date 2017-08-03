<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 权限Dao层
 */
class Dao_Privilege extends Dao {

	protected $_db = 'admin';
	
	protected $_tableName = 'privilege';
	
	protected $_primaryKey = 'privilege_id';

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
	 * 根据权限ID更新记录
	 * @param  integer $privilegeId 权限ID
	 * @param  array   $values      要更新的记录值
	 * @return integer
	 */
	public function updateByPrivilegeId($privilegeId, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $privilegeId);

		return $query->execute($this->_db);
	}

	/**
	 * 更新后辈节点路径
	 * @param  string $oldPath 老路径
	 * @param  string $newPath 新路径
	 * @return boolean
	 */
	public function updateDescendantNode($oldPath, $newPath) {
		$query = DB::query(Database::UPDATE, "update privilege set path=replace(path, :oldPath, :newPath) where position(:oldPath IN path)");
		$query->param(':oldPath', $oldPath);
		$query->param(':newPath', $newPath);

		return $query->execute($this->_db);
	}

	/**
	 * 获取所有的权限
	 */
	public function getAllPrivileges() {
		$query = DB::select()
			->from($this->_tableName)
			->order_by('sequence', 'ASC');

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据权限ID查找权限
	 * @param  integer $privilegeId 权限ID
	 * @return array
	 */
	public function getPrivilegeByPrivilegeId($privilegeId) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $privilegeId);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据权限ID查找权限
	 * @param  array $privilegeIds 权限ID
	 * @return array
	 */
	public function getPrivilegeByPrivilegeIds($privilegeIds) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, 'IN', $privilegeIds)
			->order_by('sequence', 'ASC');

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据深度获取权限
	 * @param  integer $depth 深度
	 * @return array | boolean
	 */
	public function getPrivilegesByDepth($depth) {
		/*$query = DB::select()
			->where(DB::expr('length(`path`)-length(replace(`path`,',',''))'), '<=', $depth+1);*/

		$query = DB::query(Database::SELECT, "select * from privilege where length(`path`)-length(replace(`path`,',','')) <= :depth");
		$query->param(':depth', $depth + 1);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据类型查找权限
	 * @param  string $type 权限类型
	 * @return array
	 */
	public function getPrivilegesByType($type) {
		$query = DB::select()
			->from($this->_tableName)
			->where('type', '=', $type)
			->order_by('sequence', 'ASC');

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据路径删除权限
	 * @param  string $path 路径
	 * @return boolean
	 */
	public function deleteByPath($path) {
		$query = DB::query(Database::DELETE, "delete from privilege where position(:pathStr IN path) > 0");
		$query->param(':pathStr', $path);
		
		return $query->execute($this->_db);
	}
}
