<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 角色模型
 */
class Model_Role extends Model {

	public function getCreateTimeString() {
		return date('Y-m-d H:i:s', $this->getCreateTime());
	}
}
