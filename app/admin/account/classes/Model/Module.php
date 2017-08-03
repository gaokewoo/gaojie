<?php defined('SYSPATH') or die('No direct script access.');

class Model_Module extends Model {

	/**
	 * 默认
	 */
	const STATUS_NORMAL = 0;

	/**
	 * 已删除
	 */
	const STATUS_DELETED = -1;

	public function getCreateTimeString() {
		return date('Y-m-d H:i:s', $this->getCreateTime());
	}
}