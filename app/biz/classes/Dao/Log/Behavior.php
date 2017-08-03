<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 行为日志Dao层
 */
class Dao_Log_Behavior extends Dao {

	protected $_db = 'admin';
	
	protected $_tableName = 'log_behavior';
	
	protected $_primaryKey = 'log_behavior_id';

	/**
	 * 查找所有行为日志
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getBehaviorLogs($offset = 0, $number = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->order_by($this->_primaryKey, 'DESC');

		if($offset) {
			$query->offset($offset);
		}
		if($number) {
			$query->limit($number);
		}

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 获取行为日志个数
	 */
	public function getCountBehaviorLogs() {
		$query = DB::select(DB::expr('COUNT(*) AS recordCount'))
			->from($this->_tableName)
			->order_by($this->_primaryKey, 'DESC');

		return $query->execute($this->_db)->get('recordCount');
	}

	/**
	 * 根据关键词查找日志
	 * @param  string  $keyword 关键字 
	 * @param  integer $offset  开始位置
	 * @param  integer $number  步长
	 * @return array
	 */
	public function getBehaviorLogsByKeyword($keyword = '', $offset = 0, $number = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->order_by($this->_primaryKey, 'DESC');

		if ($keyword) {
			$query->where('message', 'LIKE', '%'.$keyword.'%');
		}
		if($offset) {
			$query->offset($offset);
		}
		if($number) {
			$query->limit($number);
		}

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据关键词查找日志条数
	 * @param  string $keyword 关键字
	 * @return integer
	 */
	public function getCountBehaviorLogsByKeyword($keyword) {
		$query = DB::select(DB::expr('COUNT(*) AS recordCount'))
			->from($this->_tableName);

		if ($keyword) {
			$query->where('message', 'LIKE', '%'.$keyword.'%');
		}
		
		return $query->execute($this->_db)->get('recordCount');
	}

}
