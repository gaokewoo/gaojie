<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Role Controller
 */
class Controller_Role extends Controller_Template {

	/**
	 * 角色列表
	 */
	public function action_list() {
		$roles = BLL::Role()->getRoles()->getObject('Model_Role');

		$this->_layout->content = View::factory('role/list')
			->set('roles', $roles);
	}

	/**
	 * 添加角色
	 */
	public function action_add() {
		$this->_autoRender = false;
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('role/add');
		$this->response->body($layout->render());
	}

	/**
	 * 保存角色
	 */
	public function action_save() {
		$this->_autoRender = false;

		$name = Arr::get($_POST, 'name', '');
		$role = array(
			'name' => $name
		);
		$errors = array();
		try {
			$result = BLL::Role()->create($role)->getArray();
			if (!$result[0]) {
				$errors[] = '添加角色失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('添加角色 '.$result[0].' 成功');
		return Misc::jsonSuccess('添加成功', URL::site('role/list'));
	}

	/**
	 * 编辑角色
	 */
	public function action_edit() {
		$this->_autoRender = false;
		$roleId = Arr::get($_GET, 'roleId', 0);
		$role = BLL::Role()->getRoleByRoleId($roleId)->getObject('Model_Role')->current();
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('role/edit')
			->set('role', $role);
		$this->response->body($layout->render());
	}

	/**
	 * 修改角色
	 */
	public function action_modify() {
		$roleId = Arr::get($_POST, 'roleId', 0);
		$name = Arr::get($_POST, 'name', 0);

		$errors = array();
		if (!$roleId) {
			$errors[] = '角色ID不能为空，请选择要修改的角色！';
		}
		if (!$name) {
			$errors[] = '角色名称不能为空！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		$values = array(
			'name' => $name
		);
		try {
			$result = BLL::Role()->updateByRoleId($roleId, $values)->getArray();
			if (!$result) {
				$errors[] = '更新角色失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('更新角色 '.$roleId.' 成功');
		return Misc::jsonSuccess('更新成功', URL::site('role/list'));
	}

	/**
	 * 删除角色
	 */
	public function action_delete() {
		$ids = Arr::get($_GET, 'ids', 0);
		if (!Valid::not_empty($ids)) {
            return Misc::jsonError('请选择要删除的角色！');
        }
		$ids = explode(',', $ids);

		$errors = array();
		try {
			$result = BLL::Role()->deleteByRoleIds($ids)->getArray();
			if (!$result) {
				$errors[] = '删除角色失败';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('删除角色 '.$ids.' 成功');
		return Misc::jsonSuccess('删除成功', URL::site('role/list'));
	}

	/**
	 * 角色成员列表
	 */
	public function action_members() {
		$this->_autoRender = false;

		$roleId = Arr::get($_GET, 'roleId', 0);
		$configRoleId = Kohana::$config->load('tianyanlogo.role_id');
		$errors = array();
		if (!$roleId) {
			$errors[] = '角色ID不能为空！';
		}

		$managers = array();
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('role/member')
			->bind('errors', $errors)
			->bind('managers', $managers)
			->bind('roleId', $roleId)
			->bind('configRoleId', $configRoleId);

		$managerRoleMap = BLL::Role_Manager()->getAllByRoleId($roleId)->getArray();
		$managerIds = array();
		foreach ($managerRoleMap as $item) {
			array_push($managerIds, $item['manager_id']);
		}
		if ($managerIds) {
			$managers = BLL::manager()->getManagersByManagerIds($managerIds)->getObject('Model_Manager');
		}
		$this->response->body($layout->render());
	}

	/**
	 * 角色权限列表
	 */
	public function action_privileges() {
		$roleId = Arr::get($_GET, 'roleId', 0);

		$errors = array();
		if (!$roleId) {
			$errors[] = '角色ID不能为空！';
		}

		$privileges = array();
		$menus = array();
		$controllers = array();
		$this->_layout->content = View::factory('role/privilege')
			->bind('errors', $errors)
			->bind('privileges', $privileges)
			->bind('menus', $menus)
			->bind('controllers', $controllers)
			->bind('roleId', $roleId);

		$menus = BLL::Privilege()->getMenus()->getObject('Model_Module');
		$controllers = BLL::Privilege()->getControllers()->getObject('Model_Module');
		$originPrivileges = BLL::Role_Privilege()->getAllByRoleId($roleId)->getArray();
		foreach ($originPrivileges as $originPrivilege) {
			array_push($privileges, $originPrivilege['privilege_id']);
		}
	}

	/**
	 * 角色添加权限
	 */
	public function action_addPrivilege() {
		$this->_autoRender = false;

		$roleId = Arr::get($_POST, 'roleId', 0);
		$privilegeIds = Arr::get($_POST, 'privilegeIds', '');

		$errors = array();
		if (!Valid::not_empty($roleId)) {
			$errors[] = '角色ID不能为空！';
		}
		if (!Valid::not_empty($privilegeIds)) {
			$errors[] = '权限ID为空！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		$privilegeIds = explode(',', $privilegeIds);

		// 删除已存在的角色/权限关系
		$roleIdAndPrivilegeIdsMap = BLL::Role_Privilege()->getAllByRoleIdAndPrivilegeIds($roleId, $privilegeIds)->getArray();
		$rolePrivilegeIds = array();
		foreach ($roleIdAndPrivilegeIdsMap as $roleIdAndPrivilegeIdMap) {
			$rolePrivilegeIds[] = $roleIdAndPrivilegeIdMap['role_privilege_id'];
		}
		try {
			$result = BLL::Role_Privilege()->deleteByRolePrivilegeIds($rolePrivilegeIds)->getArray();
		} catch(Exception $e) {
			$errors[] = '权限删除失败！';
		}

		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 保存角色/权限关系
		foreach ($privilegeIds as $privilegeId) {
			$values = array(
				'role_id' => $roleId,
				'privilege_id' => $privilegeId
			);
			$result = BLL::Role_Privilege()->create($values)->getArray();
			if (!$result[0]) {
				$errors[] = '添加角色/权限关系失败！';
			}
		}

		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		return Misc::jsonSuccess('操作成功！');
	}

	/**
	 * 角色删除权限
	 */
	public function action_removePrivilege() {
		$this->_autoRender = false;

		$roleId = Arr::get($_POST, 'roleId', 0);
		$privilegeIds = Arr::get($_POST, 'privilegeIds', '');

		$errors = array();
		if (!Valid::not_empty($roleId)) {
			$errors[] = '角色ID不能为空！';
		}
		if (!Valid::not_empty($privilegeIds)) {
			$errors[] = '权限ID为空！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		$privilegeIds = explode(',', $privilegeIds);

		// 删除已存在的角色/权限关系
		$roleIdAndPrivilegeIdsMap = BLL::Role_Privilege()->getAllByRoleIdAndPrivilegeIds($roleId, $privilegeIds)->getArray();
		$rolePrivilegeIds = array();
		foreach ($roleIdAndPrivilegeIdsMap as $roleIdAndPrivilegeIdMap) {
			$rolePrivilegeIds[] = $roleIdAndPrivilegeIdMap['role_privilege_id'];
		}
		try {
			$result = BLL::Role_Privilege()->deleteByRolePrivilegeIds($rolePrivilegeIds)->getArray();
		} catch(Exception $e) {
			$errors[] = '权限删除失败！';
		}

		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		return Misc::jsonSuccess('操作成功！');
	}
}
