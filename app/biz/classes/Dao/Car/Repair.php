<?php defined('SYSPATH') or die('No direct script access.');

class Dao_Car_Repair extends Dao {
	protected $_db = 'admin';
	protected $_tableName = 'repair';
	protected $_primaryKey = 'repair_id';
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
        $query = DB::query(Database::UPDATE, "update repair set status=:deleteStatus where repair_id=:repairId");
        $query->param(':deleteStatus', self::STATUS_DELETED);
        $query->param(':repairId', $id);

        return $query->execute($this->_db);
	}

	/**
	 * @return array
	 */
	public function getAll() {
		$query = DB::select('*')
			->from($this->_tableName)
            ->where('status', '!=', self::STATUS_DELETED);

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
	 * @param  integer $id ID
	 * @return array
	 */
	public function getRepairById($id) {
		$query = DB::select('*')
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $id)
            ->where('status', '!=', self::STATUS_DELETED);

		return $query->execute($this->_db)->as_array();
    }

	/**
	 * @param  string $keyword
	 * @return array
	 */
	public function getRepairByKeyword($keyword) {
		$query = DB::select('*')
			->from($this->_tableName)
            ->where('status', '!=', self::STATUS_DELETED)
            ->and_where_open()
            ->where('people_name', 'LIKE', '%'.$keyword.'%')
            ->or_where('plate_no', 'LIKE', '%'.$keyword.'%')
            ->and_where_close();
		return $query->execute($this->_db)->as_array();
	}
}
