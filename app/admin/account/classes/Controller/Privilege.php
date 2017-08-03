<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Privilege Controller
 */
class Controller_Privilege extends Controller_Template {

	//protected $_autoRender = false;

	public function action_list() {
		$menus = BLL::Privilege()->getMenus()->getObject('Model_Module');
		$controllers = BLL::Privilege()->getControllers()->getObject('Model_Module');
		$this->_layout->content = view::factory('privilege/list')
			->set('menus', $menus)
			->set('controllers', $controllers);
	}

	/**
	 * 添加权限
	 */
	public function action_add() {
		$this->_autoRender = false;
		$modules = BLL::Module()->getModules()->getObject('Model_Module');
		$privileges = BLL::Privilege()->getPrivilegesByDepth(1)->getArray();
		//print_r($privileges);print_r(Tool::tree($privileges));exit();
		$layout = View::factory('layouts/layer');
		$layout->content = view::factory('privilege/add')
			->set('modules', $modules)
			->set('privileges', Tool::tree($privileges));
		$this->response->body($layout->render());
	}

	/**
	 * 保存权限
	 */
	public function action_save() {
		// 参数接收
		$name = Arr::get($_POST, 'name', '');
		$moduleId = Arr::get($_POST, 'module_id', 0);
		$parentId = Arr::get($_POST, 'parent_id', 0);
		$controller = Arr::get($_POST, 'controller', '');
		$action = Arr::get($_POST, 'action', '');
		$type = Arr::get($_POST, 'type', '');
		$target = Arr::get($_POST, 'target', '');
		$icon = Arr::get($_POST, 'icon', '');
		$isDisplay = Arr::get($_POST, 'is_display', 0);
		$sequence = Arr::get($_POST, 'sequence', 0);

		// 合法性检测
		$errors = array();
		if (!Valid::not_empty($name)) {
			$errors[] = '权限名称不能为空！';
		}
		if (!Valid::not_empty($moduleId)) {
			$errors[] = '请选择模块！';
		}
		$module = BLL::Module()->getModuleByModuleId($moduleId)->getObject('Model_Module');
		if ($module->count() <= 0) {
			$errors[] = '所选模块不存在！';
		}
		if (!Valid::not_empty($type)) {
			$errors[] = '请选择类型！';
		} else {
			if (!in_array($type, array(Model_Privilege::TYPE_CONTROLLER, Model_Privilege::TYPE_MENU, Model_Privilege::TYPE_NAVIGATOR))) {
				$errors[] = '权限类型不正确！';
			}
		}
		if ($type == Model_Privilege::TYPE_CONTROLLER) {
			if (!Valid::not_empty($controller) && !Valid::not_empty($target)) {
				$errors[] = '当权限类型为控制器时，控制器或目标地址至少填写一个！';
			}
		}
		if($type == Model_Privilege::TYPE_CONTROLLER && !$parentId) {
			$errors[] = '权限类型是控制器时，上级必选！';
		}
		if($type == Model_Privilege::TYPE_MENU && $parentId) {
			$errors[] = '权限类型是菜单时，上级不选！';
		}
		if (!in_array($isDisplay, array(0, 1))) {
			$errors[] = '是否显示数据不合法！';
		}
		if($sequence == '') {
			$errors[] = '排序不能为空！';
		}
		if ($sequence != '' && !Valid::digit($sequence)) {
			$errors[] = '排序必须为整数！';
		}
		// 获取path值
		if (Valid::not_empty($parentId)) {
			$parentPrivilege = BLL::Privilege()->getPrivilegeByPrivilegeId($parentId)->getObject('Model_Privilege');
			if ($parentPrivilege->count() <= 0) {
				$errors[] = '所选上级不存在！';
			}
			$path = $parentPrivilege->current()->getPath();
		} else {
			$path = '0,';
		}

		if ($errors) {
			return Misc::jsonError($errors);
		}

		$module = $module->current();
		//权限是'菜单'时，没有父级，parent_id设为0
		if(empty($parentId)) {
			$parentId = 0;
		}
		if(!$sequence) {
			$sequence = 0;
		}
		// 信息入库
		$values = array(
			'name' => $name,
			'parent_id' => $parentId,
			'path' => '',
			'module_id' => $moduleId,
			'portal' => $module->getPortal(),
			'module' => $module->getModule(),
			'controller' => $controller,
			'action' => $action,
			'target' => $target,
			'icon' => $icon,
			'type' => $type,
			'is_display' => $isDisplay,
			'sequence' => $sequence,
		);
		try {
			$result = BLL::Privilege()->create($values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '插入privilege表失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		// 更新path路径信息
		$insertId = $result[0];
		$path .= $insertId . ',';
		try {
			$values = array(
				'path' => $path
			);
			$result = BLL::Privilege()->updateByPrivilegeId($insertId, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = 'privilege表更新path失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('新增权限 '.$insertId.' 成功');
		return Misc::jsonSuccess('新增权限成功', URL::site('privilege/list'));
	}

	/**
	 * 编辑权限
	 */
	public function action_edit() {
		$this->_autoRender = false;
		$privilegeId = Arr::get($_GET, 'privilegeId', 0);
		$errors = array();
		if (!Valid::not_empty($privilegeId)) {
			$errors[] = 'privilegeId为空！';	
		}
		if ($errors) {
			return Misc::message(implode(',', $errors), '/privilege/list');
		}
		$privilege = BLL::Privilege()->getPrivilegeByPrivilegeId($privilegeId)->getObject('Model_Privilege');
		if (!Valid::not_empty($privilege)) {
			$errors[] = '权限不存在！';
		}
		if ($errors) {
			return Misc::message(implode(',', $errors), '/privilege/list');
		}

		$modules = BLL::Module()->getModules()->getObject('Model_Module');
		$privileges = BLL::Privilege()->getPrivilegesByDepth(1)->getArray();
		//print_r($privileges);print_r(Tool::tree($privileges));exit();
		$layout = View::factory('layouts/layer');
		$layout->content = view::factory('privilege/edit')
			->set('modules', $modules)
			->set('privileges', Tool::tree($privileges))
			->set('privilegeCur', $privilege->current());
		$this->response->body($layout->render());
	}

	/**
	 * 编辑保存
	 */
	public function action_modify() {
		// 参数接收
		$privilegeId = Arr::get($_POST, 'privilegeId', 0);
		$name = Arr::get($_POST, 'name', '');
		$moduleId = Arr::get($_POST, 'module_id', 0);
		$parentId = Arr::get($_POST, 'parent_id', 0);
		$controller = Arr::get($_POST, 'controller', '');
		$action = Arr::get($_POST, 'action', '');
		$type = Arr::get($_POST, 'type', '');
		$target = Arr::get($_POST, 'target', '');
		$icon = Arr::get($_POST, 'icon', '');
		$isDisplay = Arr::get($_POST, 'is_display', 0);
		$sequence = Arr::get($_POST, 'sequence', 0);

		// 合法性检测
		$errors = array();
		if (!Valid::not_empty($privilegeId)) {
			$errors[] = '权限ID不能为空！';
		}
		$privilege = BLL::Privilege()->getPrivilegeByPrivilegeId($privilegeId)->getObject('Model_Privilege');
		if (!Valid::not_empty($privilege)) {
			$errors[] = '该权限不存在！';
		}
		if (!Valid::not_empty($name)) {
			$errors[] = '权限名称不能为空！';
		}
		if (!Valid::not_empty($moduleId)) {
			$errors[] = '请选择模块！';
		}
		$module = BLL::Module()->getModuleByModuleId($moduleId)->getObject('Model_Module');
		if ($module->count() <= 0) {
			$errors[] = '所选模块不存在！';
		}
		if (!Valid::not_empty($type)) {
			$errors[] = '请选择类型！';
		} else {
			if (!in_array($type, array(Model_Privilege::TYPE_CONTROLLER, Model_Privilege::TYPE_MENU, Model_Privilege::TYPE_NAVIGATOR))) {
				$errors[] = '权限类型不正确！';
			}
		}
		if ($type == Model_Privilege::TYPE_CONTROLLER) {
			if (!Valid::not_empty($controller) && !Valid::not_empty($target)) {
				$errors[] = '当权限类型为控制器时，控制器或目标地址至少填写一个！';
			}
		}
		if($type == Model_Privilege::TYPE_CONTROLLER && !$parentId) {
			$errors[] = '权限类型是控制器时，上级必选！';
		}
		if($type == Model_Privilege::TYPE_MENU && $parentId) {
			$errors[] = '权限类型是菜单时，上级不选！';
		}
		if (!in_array($isDisplay, array(0, 1))) {
			$errors[] = '是否显示数据不合法！';
		}
		if($sequence == '') {
			$errors[] = '排序不能为空！';
		}
		if ($sequence != '' && !Valid::digit($sequence)) {
			$errors[] = '排序必须为整数！';
		}
		// 获取path值
		if (Valid::not_empty($parentId)) {
			$parentPrivilege = BLL::Privilege()->getPrivilegeByPrivilegeId($parentId)->getObject('Model_Privilege');
			if ($parentPrivilege->count() <= 0) {
				$errors[] = '所选上级不存在！';
			}
			$path = $parentPrivilege->current()->getPath();
			// 当前节点不能移动至自身和后辈节点下
			if (stripos($path, $privilege->current()->getPath()) === 0) {
				$errors[] = '当前节点不能移动至自身和后辈节点下!';
			}
			$path .= $privilegeId . ',';
		} else {
			$path = '0,' . $privilegeId . ',';
		}

		if ($errors) {
			return Misc::jsonError($errors);
		}

		$privilege = $privilege->current();
		$module = $module->current();
		//权限是'菜单'时，没有父级，parent_id设为0
		if(empty($parentId)) {
			$parentId = 0;
		}
		// 信息更新入库
		$values = array(
			'name' => $name,
			'parent_id' => $parentId,
			'path' => $path,
			'module_id' => $moduleId,
			'portal' => $module->getPortal(),
			'module' => $module->getModule(),
			'controller' => $controller,
			'action' => $action,
			'target' => $target,
			'icon' => $icon,
			'type' => $type,
			'is_display' => $isDisplay,
			'sequence' => $sequence,
		);
		try {
			$result = BLL::Privilege()->updateByPrivilegeId($privilegeId, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '更新privilege表失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		// 更新后辈节点路径
		if ($parentId != $privilege->getParentId()) {
			$oldPath = $privilege->getPath();
			$newPath = $path;
			try {
				$result = BLL::Privilege()->updateDescendantNode($oldPath, $newPath)->getArray();
				if ($result === false) {
					$errors[] = 'privilege表更新后辈节点失败！';
				}
			} catch(Exception $e) {
				$errors[] = $e->getMessage();
			}
			if ($errors) {
				Logger_Client::behaviorLog(implode("\t", $errors));
				return Misc::jsonError($errors);
			}
		}
		Logger_Client::behaviorLog('更新权限 '.$privilegeId.' 成功');
		return Misc::jsonSuccess('更新权限成功', URL::site('privilege/list'));
	}

	/**
	 * 删除权限
	 */
	public function action_delete() {
		$privilegeId = Arr::get($_GET, 'privilegeId', 0);

		// 合法性检测
		$errors = array();
		if (!Valid::not_empty($privilegeId)) {
			$errors[] = '权限ID不能为空！';
		}
		$privilege = BLL::Privilege()->getPrivilegeByPrivilegeId($privilegeId)->getObject('Model_Privilege');
		if (!Valid::not_empty($privilege)) {
			$errors[] = '该权限不存在！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		$privilege = $privilege->current();
		$result = BLL::Privilege()->deleteByPath($privilege->getPath())->getArray();
		if (!Valid::not_empty($result)) {
			$errors[] = '删除失败！';
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('删除权限 '.$privilegeId.' 成功');
		return Misc::jsonSuccess('删除成功！', URL::site('privilege/list'));
	}
}
