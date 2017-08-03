<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 行为日志
 */
class Model_Log_Behavior extends Model {

	 /**
	 * 获取用户审核驳回原因
	 */
	public function getRejectReason() {
		$message = explode(' ', $this->message, 3);
		if(isset($message[2])) {
			$rejectReasons = array_values(unserialize($message[2]));
			return implode('<br />', $rejectReasons);
		}
		return '';
	}

	/**
	 * 获取用户审核日志 - 用户ID
	 */
	public function getApproveUserId() {
		$message = explode(' ', $this->message, 3);
		if(isset($message[0])) {
			$userStr = trim($message[0], 'uid:');
			$userArr = explode(',', $userStr);
			return isset($userArr[0]) ? $userArr[0] : '';
		}
		return '';
	}

	/**
	 * 获取用户审核日志 - 用户昵称
	 */
	public function getApproveNickName() {
		$message = explode(' ', $this->message, 3);
		if(isset($message[0])) {
			$userStr = trim($message[0], 'uid:');
			$userArr = explode(',', $userStr);
			return isset($userArr[1]) ? $userArr[1] : '';
		}
		return '';
	}

	/**
	 * 获取用户审核日志 - 审核过程
	 */
	public function getApproveOperate() {
		$message = explode(' ', $this->message, 3);
		return isset($message[1]) ? $message[1] : '';
	}

	public function getCreateTimeString() {
		return date('Y-m-d H:i:s', $this->getCreateTime());
	}

	/**
	 * 获取日志动作
	 * @return
	 */
	public function getUri() {
		return $this->portal.'/'. $this->controller. '/'. $this->action;
	}
}