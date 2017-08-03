<?php defined('SYSPATH') or die('No direct script access.');

class Model_Manager extends Model {

	public function getStatusString() {
		if ($this->getStatus() == Dao_Manager::STATUS_NORMAL) {
			$statusString = '正常';
		} elseif ($this->getStatus() == Dao_Manager::STATUS_DELETED) {
			$statusString = '屏蔽';
		} else {
			$statusString = '未知';
		}
		return $statusString;
	}
}