<?php defined('SYSPATH') or die('No direct script access.');

class Dao_Car_Repair_Detail extends Dao {
	protected $_db = 'admin';
	protected $_tableName = 'repair_detail';
	protected $_primaryKey = 'repair_detail_id';
	const STATUS_DELETED = -1; //已删除状态

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
	 * 根据id删除记录
	 * @param  integer $id
	 * @return boolean
	 */
	public function deleteById($id) {
		return DB::delete($this->_tableName)
			->where($this->_primaryKey, '=', $id)
			->execute($this->_db);
	}

	/**
	 * @return array
	 */
	public function getAll() {
		$query = DB::select('*')
			->from($this->_tableName);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * @param  integer $id ID
	 * @param  array   $values
	 * @return array
	 */
	public function updateById($id, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $id);

		return $query->execute($this->_db);
	}
    
    /**
	 * 根据repair_id查找
	 * @param  integer $id
	 * @return boolean
	 */
	public function selectByRepairId($id) {
		$query = DB::select('*')
			->from($this->_tableName)
            ->where('repair_id', '=', $id)
            ->where('status', '!=', self::STATUS_DELETED);

        return $query->execute($this->_db)->as_array();
	}

    /**
	 * 根据repair_id删除
	 * @param  integer $id
	 * @return boolean
	 */
	public function deleteByRepairId($id) {
        $query = DB::query(Database::UPDATE, "update repair_detail set status=:deleteStatus where repair_id=:repairId and status!=:deleteStatus");
        $query->param(':deleteStatus', self::STATUS_DELETED);
        $query->param(':repairId', $id);

        return $query->execute($this->_db);
	}
}
