<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 异常日志Dao层
 */
class Dao_Log_Crash extends Dao {

	protected $_db = 'admin';
	
	protected $_tableName = 'log_crash';
	
	protected $_primaryKey = 'log_crash_id';

	/**
	 * 查找所有异常日志
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getCrashLogs($offset = 0, $number = 0) {
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
	 * 获取异常日志个数
	 */
	public function getCountCrashLogs() {
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
	public function getCrashLogsByKeyword($keyword = '', $offset = 0, $number = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->order_by($this->_primaryKey, 'DESC');

		if ($keyword) {
			$query->where('file', 'LIKE', '%'.$keyword.'%');
			$query->or_where('message', 'LIKE', '%'.$keyword.'%');
			$query->or_where('ip', 'LIKE', '%'.$keyword.'%');
			$query->or_where('hostname', 'LIKE', '%'.$keyword.'%');
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
	public function getCountCrashLogsByKeyword($keyword) {
		$query = DB::select(DB::expr('COUNT(*) AS recordCount'))
			->from($this->_tableName);

		if ($keyword) {
			$query->where('file', 'LIKE', '%'.$keyword.'%');
			$query->or_where('message', 'LIKE', '%'.$keyword.'%');
			$query->or_where('ip', 'LIKE', '%'.$keyword.'%');
			$query->or_where('hostname', 'LIKE', '%'.$keyword.'%');
		}
		
		return $query->execute($this->_db)->get('recordCount');
	}
}
