<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 行为日志业务逻辑层
 */
class Business_Log_Behavior extends Business {

	/**
	 * 查找所有行为日志
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getBehaviorLogs($offset = 0, $number = 0) {
		$result = Dao::factory('Log_Behavior')->getBehaviorLogs($offset, $number);
		return $result;
	}

	/**
	 * 获取行为日志个数
	 */
	public function getCountBehaviorLogs() {
		return Dao::factory('Log_Behavior')->getCountBehaviorLogs();
	}

	/**
	 * 根据关键词查找日志
	 * @param  string  $keyword 关键字 
	 * @param  integer $offset  开始位置
	 * @param  integer $number  步长
	 * @return array
	 */
	public function getBehaviorLogsByKeyword($keyword = '', $offset = 0, $pageSize = 0) {
		$result = Dao::factory('Log_Behavior')->getBehaviorLogsByKeyword($keyword, $offset, $pageSize);
		return $result;
	}

	/**
	 * 根据关键词查找日志条数
	 * @param  string $keyword 关键字
	 * @return integer
	 */
	public function getCountBehaviorLogsByKeyword($keyword) {
		return Dao::factory('Log_Behavior')->getCountBehaviorLogsByKeyword($keyword);
	}

	/**
	 * 获取某个用户的驳回历史
	 * @param integer $uid 用户ID
	 */
	public function getRejectLogsByUid($uid = 0) {
		return Dao::factory('Log_Behavior')->getRejectLogsByUid($uid);
	}

	/**
	 * 查找所有审核日志
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getApproveLogs($offset = 0, $number = 0) {
		$result = Dao::factory('Log_Behavior')->getApproveLogs($offset, $number);
		return $result;
	}

	/**
	 * 获取审核日志个数
	 */
	public function getCountApproveLogs() {
		return Dao::factory('Log_Behavior')->getCountApproveLogs();
	}

	/**
	 * 根据关键词查找日志
	 * @param  string  $keyword 关键字 
	 * @param  integer $offset  开始位置
	 * @param  integer $number  步长
	 * @return array
	 */
	public function getApproveLogsByKeyword($keyword = '', $offset = 0, $pageSize = 0) {
		$result = Dao::factory('Log_Behavior')->getApproveLogsByKeyword($keyword, $offset, $pageSize);
		return $result;
	}

	/**
	 * 根据关键词查找日志条数
	 * @param  string $keyword 关键字
	 * @return integer
	 */
	public function getCountApproveLogsByKeyword($keyword) {
		return Dao::factory('Log_Behavior')->getCountApproveLogsByKeyword($keyword);
	}


}
