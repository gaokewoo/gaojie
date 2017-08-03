<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Module Controller
 */
class Controller_Module extends Controller_Template {

	/**
	 * 模块列表
	 */
	public function action_list() {
		$modules = BLL::Module()->getModules()->getObject('Model_Module');
		$this->_layout->content = View::factory('module/list')
			->set('modules', $modules);
	}

	/**
	 * 添加模块
	 */
	public function action_add() {
		$this->_autoRender = false;
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('module/add');
		$this->response->body($layout->render());
	}

	/**
	 * 保存模块
	 */
	public function action_save() {
		$this->_autoRender = false;

		$name   = Arr::get($_POST, 'name', '');
		$moduleName = Arr::get($_POST, 'module_name', '');
		$portal = Arr::get($_POST, 'portal', '');
		$module = array(
			'name' => $name,
			'module' => $moduleName,
			'portal' => $portal
		);
		$errors = array();
		try {
			$result = BLL::Module()->create($module)->getArray();
			if (!$result[0]) {
				$errors[] = '添加模块失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('添加模块 '.$result[0].' 成功');
		return Misc::jsonSuccess('添加成功', URL::site('module/list'));
	}

	/**
	 * 编辑模块
	 */
	public function action_edit() {
		$this->_autoRender = false;
		$moduleId = Arr::get($_GET, 'moduleId', 0);
		$module = BLL::Module()->getModuleByModuleId($moduleId)->getObject('Model_Module');
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('module/edit')
			->set('module', $module[0]);
		$this->response->body($layout->render());
	}

	/**
	 * 修改模块
	 */
	public function action_modify() {
		$moduleId = Arr::get($_POST, 'moduleId', 0);
		$name   = Arr::get($_POST, 'name', '');
		$moduleName = Arr::get($_POST, 'module_name', '');
		$portal = Arr::get($_POST, 'portal', '');

		$errors = array();
		if (!$moduleId) {
			$errors[] = '模块ID不能为空，请选择要修改的模块！';
		}
		if (!$name) {
			$errors[] = '模块名称不能为空！';
		}
		if (!$portal) {
			$errors[] = '模块入口文件不能为空！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		$values = array(
			'name' => $name,
			'module' => $moduleName,
			'portal' => $portal
		);
		try {
			$result = BLL::Module()->updateByModuleId($moduleId, $values)->getArray();
			if (!$result) {
				$errors[] = '更新模块失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('更新模块 '.$moduleId.' 成功');
		return Misc::jsonSuccess('更新成功', URL::site('module/list'));
	}

	/**
	 * 删除模块
	 */
	public function action_delete() {
		$ids = Arr::get($_GET, 'ids', 0);
		$ids = explode(',', $ids);

		$errors = array();
		if (!$ids) {
			$errors[] = '模块ID不能为空，请选择要删除的模块！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}
		try {
			$values = array(
				'status' => Model_Module::STATUS_DELETED
			);
			$result = BLL::Module()->updateByModuleIds($ids, $values)->getArray();
			if (!$result) {
				$errors[] = '删除模块失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('删除模块 '.$ids.' 成功');
		return Misc::jsonSuccess('删除成功', URL::site('module/list'));
	}

	/**
	 * 恢复模块
	 */
	public function action_recover() {
		$moduleId = Arr::get($_GET, 'moduleId', 0);
		$errors = array();
		if (!$moduleId) {
			$errors[] = '模块ID不能为空，请选择要恢复的模块！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}
		try {
			$values = array(
				'status' => Model_Module::STATUS_NORMAL
			);
			$result = BLL::Module()->updateByModuleId($moduleId, $values)->getArray();
			if (!$result) {
				$errors[] = '恢复模块失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('恢复模块 '.$moduleId.' 成功');
		return Misc::jsonSuccess('恢复模块成功', URL::site('module/list'));
	}
}
