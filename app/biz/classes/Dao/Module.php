<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 模块 Dao 层
 */
class Dao_Module extends Dao {

	protected $_db = 'admin';

	protected $_tableName = 'module';

	protected $_primaryKey = 'module_id';

	/**
	 * 默认
	 */
	const STATUS_NORMAL = 0;

	/**
	 * 已删除
	 */
	const STATUS_DELETED = -1;

	/**
	 * 添加模块
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
	 * 根据模块ID更新模块信息
	 * @param  integer $moduleId 模块ID
	 * @param  array   $values 要更新的模块信息
	 * @return array
	 */
	public function updateByModuleId($moduleId, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $moduleId);

		return $query->execute($this->_db);
	}

	/**
	 * 根据模块ID更新模块信息
	 * @param  array $moduleIds 模块ID
	 * @param  array $values 要更新的模块信息
	 * @return array
	 */
	public function updateByModuleIds($moduleIds, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, 'IN', $moduleIds);

		return $query->execute($this->_db);
	}

	/**
	 * 获取模块
	 * @return array
	 */
	public function getModules() {
		$query = DB::select()
			->from($this->_tableName)
			->where('status', '=', self::STATUS_NORMAL);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据模块ID获取模块
	 * @param  integer $moduleId 模块ID
	 * @return array
	 */
	public function getModuleByModuleId($moduleId) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $moduleId);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据模块ID获取模块信息
	 * @param  array $moduleIds 模块ID
	 * @return array
	 */
	public function getModulesByModuleIds($moduleIds) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, 'IN', $moduleIds);

		return $query->execute($this->_db)->as_array();
	}
}
