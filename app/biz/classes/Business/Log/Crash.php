<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 异常日志业务逻辑层
 */
class Business_Log_Crash extends Business {

	/**
	 * 查找所有异常日志
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getCrashLogs($offset = 0, $number = 0) {
		$result = Dao::factory('Log_Crash')->getCrashLogs($offset, $number);
		return $result;
	}

	/**
	 * 获取异常日志个数
	 */
	public function getCountCrashLogs() {
		return Dao::factory('Log_Crash')->getCountCrashLogs();
	}

	/**
	 * 根据关键词查找日志
	 * @param  string  $keyword 关键字 
	 * @param  integer $offset  开始位置
	 * @param  integer $number  步长
	 * @return array
	 */
	public function getCrashLogsByKeyword($keyword = '', $offset = 0, $pageSize = 0) {
		$result = Dao::factory('Log_Crash')->getCrashLogsByKeyword($keyword, $offset, $pageSize);
		return $result;
	}

	/**
	 * 根据关键词查找日志条数
	 * @param  string $keyword 关键字
	 * @return integer
	 */
	public function getCountCrashLogsByKeyword($keyword) {
		return Dao::factory('Log_Crash')->getCountCrashLogsByKeyword($keyword);
	}

}
