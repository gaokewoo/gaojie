<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 模块业务逻辑层
 */
class Business_Module extends Business {

	/**
	 * 创建模块
	 * @param array $values
	 * @return boolean
	 */
	public function create(array $values){
		$fields = array (
			'name' => '',
			'module' => '',
			'portal' => '',
			'status' => Model_Module::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time()
		);

		$errors = array();
		$name = Arr::get($values,'name');
		if(!$name) {
			$errors[] = '模块名称不能为空！';
		}
		$portal = Arr::get($values,'portal');
		if(!$portal) {
			$errors[] = '入口文件不能为空！';
		}
		if($errors) {
			throw new Business_Exception(implode(' ', $errors));
		}

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Module')->insert($values);
	}

	/**
	 * 根据模块ID更新模块信息
	 * @param  integer $moduleId 模块ID
	 * @param  array   $values 要更新的模块信息
	 * @return boolean
	 */
	public function updateByModuleId($moduleId, $values) {
		$errors = array();
		if (!$moduleId || !$values) {
			$errors[] = '参数不正确！';
		}
		$fields = array (
			'name' => '',
			'module' => '',
			'portal' => '',
			'status' => Model_Module::STATUS_NORMAL
		);
		$values = array_intersect_key($values, $fields);
		if (count($values) < 1) {
			$errors[] = '没有要被更新的字段';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		$values['update_time'] = time();

		return Dao::factory('Module')->updateByModuleId($moduleId, $values);
	}

	/**
	 * 根据模块ID更新模块信息
	 * @param  array $moduleIds 模块ID
	 * @param  array $values 要更新的模块信息
	 * @return boolean
	 */
	public function updateByModuleIds($moduleIds, $values) {
		$errors = array();
		if (!$moduleIds || !$values) {
			$errors[] = '参数不正确！';
		}
		$fields = array (
			'name' => '',
			'module' => '',
			'portal' => '',
			'status' => Model_Module::STATUS_NORMAL
		);
		$values = array_intersect_key($values, $fields);
		if (count($values) < 1) {
			$errors[] = '没有要被更新的字段';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		$values['update_time'] = time();

		return Dao::factory('Module')->updateByModuleIds($moduleIds, $values);
	}

	/**
	 * 获取所有模块
	 * @return array
	 */
	public function getModules() {
		return Dao::factory('Module')->getModules();
	}

	/**
	 * 根据模块ID获取模块
	 * @param  integer $moduleId 模块ID
	 * @return array
	 */
	public function getModuleByModuleId($moduleId) {
		if (!$moduleId) {
			return array();
		}
		return Dao::factory('Module')->getModuleByModuleId($moduleId);
	}
}
