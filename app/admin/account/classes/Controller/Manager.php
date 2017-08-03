<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The manager controller
 */
class Controller_Manager extends Controller_Template {

	/**
	 * 管理员列表
	 */
	public function action_list() {
		$page = Arr::get($_GET, 'page', 1);
		$number  = Arr::get($_GET, 'number', 20);
		$keyword = htmlspecialchars(Arr::get($_GET, 'keyword', ''));

		if (Valid::not_empty($keyword)) {
			$count = BLL::Manager()->getCountManagersByKeyword($keyword)->getArray();
			$pagination = Pagination::factory($count, $number)->execute();
			$offset = $pagination->offset;
			$managers = BLL::Manager()->getManagersByKeyword($keyword, $offset, $number)->getObject('Model_Manager');
		} else {
			$count = BLL::Manager()->getCountManagers()->getArray();
			$pagination = Pagination::factory($count, $number)->execute();
			$offset = $pagination->offset;
			$managers = BLL::Manager()->getManagers($offset, $number)->getObject('Model_Manager');
		}

		$this->_layout->content = View::factory('manager/list')
			->set('managers', $managers)
			->set('pagination', $pagination)
			->set('keyword', $keyword);
	}

	/**
	 * 添加管理员
	 */
	public function action_add() {
		$this->_autoRender = false;

		$roles = BLL::Role()->getRoles()->getObject('Model_Role');
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('manager/add')
			->set('roles', $roles);
		$this->response->body($layout->render());
	}

	/**
	 * 保存管理员信息
	 */
	public function action_save() {
		$this->_autoRender = false;

		$givenName = Arr::get($_POST, 'given_name', '');
		$type = Arr::get($_POST, 'type', '');
		$staffId = Arr::get($_POST, 'staff_id', 0);
		$email = Arr::get($_POST, 'email', '');
		$password = Arr::get($_POST, 'password', '');
		$mobile = Arr::get($_POST, 'mobile', '');
		$phone = Arr::get($_POST, 'phone', '');
		$roleIds = Arr::get($_POST, 'roleIds', '');
		$loginType = Arr::get($_POST, 'login_type', 0);

		// 数据合法性检测
		$errors = array();
		if (!Valid::not_empty($givenName)) {
			$errors[] = '姓名不能为空！';
		}
		if (!Valid::not_empty($type)) {
			$errors[] = '请选择员工类型！';
		} else {
			if ($type == Dao_Manager::TYPE_FULLTIME) {
				if (!Valid::not_empty($staffId)) {
					$errors[] = '请填写员工号！';
				} elseif(!Valid::digit($staffId)) {
					$errors[] = '员工号格式不正确！';
				}
			}
		}
		if (!Valid::not_empty($email)) {
			$errors[] = '邮箱不能为空！';
		} elseif (!Valid::email($email)) {
			$errors[] = '邮箱格式不正确！';
		}
		$manager = BLL::Manager()->getManagerByEmail($email)->getObject('Model_Manager');
		if (count($manager) >= 1) {
			$errors[] = '该邮箱已开通权限，不能重复申请！';
		}
		if($mobile && !Valid::phone($mobile)) {
			$errors[] = '手机号格式不正确！';
		}
		if (!Valid::not_empty($roleIds)) {
			$errors[] = '请选择角色！';
		} else {
			$roles = BLL::Role()->getRoles()->getObject('Model_Role');
			foreach ($roleIds as $roleId) {
				$flag = false;
				foreach($roles as $role) {
					if ($roleId == $role->getRoleId()) {
						$flag = true;
						break;
					}
				}
				if (!$flag) {
					$errors[] = '角色不存在！';
				}
			}
		}

		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 管理员信息入库
		$values = array(
			'given_name' => $givenName,
			'type' => $type,
			'staff_id' => $staffId,
			'email' => $email,
			'phone' => $phone,
			'mobile' => $mobile,
			'weibo_uid' => 0,
			'approve_status' => Dao_Manager::STATUS_APPROVE_SUCCESS,
			'login_type' => Dao_Manager::LOGIN_TYPE_TODO
		);
		if (Valid::not_empty($password)) {
			$values['password'] = md5($password);
		}
		try {
			$result = BLL::Manager()->create($values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '插入manager表失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		// 管理员和角色关系入库
		$insertId = $result[0];
		foreach ($roleIds as $roleId) {
			$values = array(
				'manager_id' => $insertId,
				'role_id' => $roleId
			);
			$result = BLL::Role_Manager()->create($values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '管理员/角色入库失败';
				break;
			}
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('新增用户成功 '.$insertId.' 成功');
		return Misc::jsonSuccess('新增用户成功', URL::site('manager/list'));
	}

	/**
	 * 编辑管理员
	 */
	public function action_edit() {
		$this->_autoRender = false;

		$errors = array();
		$roles = array();
		$managerRoleMap = array();
		$manager = null;
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('manager/edit')
			->bind('roles', $roles)
			->bind('managerRoleMap', $managerRoleMap)
			->bind('manager', $manager)
			->bind('errors', $errors);

		$managerId = Arr::get($_GET, 'managerId', 0);
		if (!Valid::not_empty($managerId)) {
			$errors[] = 'managerId为空！';
		}
		if ($errors) {
			return $this->response->body($layout->render());
		}
		$manager = BLL::Manager()->getManagerByManagerId($managerId)->getObject('Model_Manager');
		if (!Valid::not_empty($manager)) {
			$errors[] = '用户不存在！';
		}
		if($manager->current()->getGivenName() == 'root' && Manager::givenName() != 'root') {
			$errors[] = '没有权限修改！';
		}
		if ($errors) {
			return $this->response->body($layout->render());
		}
		$manager = $manager->current();
		// 获取所有角色
		$roles = BLL::Role()->getRoles()->getObject('Model_Role');
		// 获取管理员和角色对应关系
		$managerRoleMap = BLL::Role_Manager()->getAllByManagerId($managerId)->getArray();

		$this->response->body($layout->render());
	}

	/**
	 * 编辑保存管理员
	 */
	public function action_modify() {
		$this->_autoRender = false;

		$managerId = Arr::get($_POST, 'manager_id', '');
		$givenName = Arr::get($_POST, 'given_name', '');
		$type = Arr::get($_POST, 'type', '');
		$staffId = Arr::get($_POST, 'staff_id', 0);
		$password = Arr::get($_POST, 'password', '');
		$mobile = Arr::get($_POST, 'mobile', '');
		$phone = Arr::get($_POST, 'phone', '');
		$roleIds = Arr::get($_POST, 'roleIds', '');
		$loginType = Arr::get($_POST, 'login_type', 0);

		// 数据合法性检测
		$errors = array();
		if (!Valid::not_empty($managerId)) {
			$errors[] = '管理员ID不能为空！';
		}
		$manager = BLL::Manager()->getManagerByManagerId($managerId)->getObject('Model_Manager');
		if (count($manager) < 1) {
			$errors[] = '管理员不存在！';
		}
		if (!Valid::not_empty($givenName)) {
			$errors[] = '姓名不能为空！';
		}
		if (!Valid::not_empty($type)) {
			$errors[] = '请选择员工类型！';
		} else {
			if ($type == Dao_Manager::TYPE_FULLTIME) {
				if (!Valid::not_empty($staffId)) {
					$errors[] = '请填写员工号！';
				} elseif(!Valid::digit($staffId)) {
					$errors[] = '员工号格式不正确！';
				}
			} else {
				$staffId = 0;
			}
		}
		if($mobile && !Valid::phone($mobile)) {
			$errors[] = '手机号格式不正确！';
		}
		if (!Valid::not_empty($roleIds)) {
			$errors[] = '请选择角色！';
		} else {
			$roles = BLL::Role()->getRoles()->getObject('Model_Role');
			foreach ($roleIds as $roleId) {
				$flag = false;
				foreach($roles as $role) {
					if ($roleId == $role->getRoleId()) {
						$flag = true;
						break;
					}
				}
				if (!$flag) {
					$errors[] = '角色不存在！';
				}
			}
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 管理员信息入库
		$values = array(
			'given_name' => $givenName,
			'type' => $type,
			'staff_id' => $staffId,
			'phone' => $phone,
			'mobile' => $mobile,
			'weibo_uid' => 0,
			'approve_status' => Dao_Manager::STATUS_APPROVE_SUCCESS,
			'login_type' => Dao_Manager::LOGIN_TYPE_TODO
		);
		if (Valid::not_empty($password)) {
			$values['password'] = md5($password);
		}
		try {
			$result = BLL::Manager()->updateByManagerId($managerId, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '更新manager表失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}

		// 删除已有关系
		$result = BLL::Role_Manager()->deleteByManagerId($managerId)->getArray();
		if ($result === false) {
			$errors[] = '删除管理员/角色关系失败！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 管理员和角色关系入库
		foreach ($roleIds as $roleId) {
			$values = array(
				'manager_id' => $managerId,
				'role_id' => $roleId
			);
			$result = BLL::Role_Manager()->create($values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '管理员/角色入库失败！';
				break;
			}
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('编辑用户 '.$managerId.' 成功');
		return Misc::jsonSuccess('编辑用户成功！', URL::site('manager/list'));
	}

	/**
	 * 启用用户
	 */
	public function action_enable() {
		$this->_autoRender = false;

		$ids = Arr::get($_GET, 'ids', '');
		$ids = explode(',', $ids);
		if (!Valid::not_empty($ids)) {
			return Misc::jsonError('请选择用户！');
		}
		$errors = array();
		try {
			$values = array(
				'status' => Dao_Manager::STATUS_NORMAL
			);
			$result = BLL::Manager()->updateByManagerIds($ids, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '启用失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('启用管理员 '. implode(',', $ids) .' 成功');
		return Misc::jsonSuccess('启用成功', URL::site('manager/list'));
	}

	/**
	 * 禁用用户
	 */
	public function action_disable() {
		$this->_autoRender = false;

		$ids = Arr::get($_GET, 'ids', '');
		$ids = explode(',', $ids);
		if (!Valid::not_empty($ids)) {
			return Misc::jsonError('请选择用户！');
		}
		$errors = array();
		try {
			$values = array(
				'status' => Dao_Manager::STATUS_DELETED
			);
			$result = BLL::Manager()->updateByManagerIds($ids, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '禁用失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('禁用管理员 ' . implode(',', $ids) .' 成功');
		return Misc::jsonSuccess('禁用成功', URL::site('manager/list'));
	}

	/**
	 * 个人设置
	 */
	public function action_profileEdit() {
		$this->_autoRender = FALSE;

		$managerId = Arr::get($_GET, 'userId', 0);
		$errors = array();
		if (!Valid::not_empty($managerId)) {
			$errors[] = 'userId为空！';
		}
		if ($errors) {
			return Misc::message(implode(',', $errors), '/default');
		}
		$manager = BLL::Manager()->getManagerByManagerId($managerId)->getObject('Model_Manager');
		if (!Valid::not_empty($manager)) {
			$errors[] = '用户不存在！';
		}
		if ($errors) {
			return Misc::message(implode(',', $errors), '/default');
		}
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('manager/profile/edit')
			->set('manager', $manager->current());
		$this->response->body($layout->render());
	}

	/**
	 * 个人设置保存
	 */
	public function action_profileModify() {
		$this->_autoRender = false;

		$managerId = Arr::get($_POST, 'manager_id', '');
		$givenName = Arr::get($_POST, 'given_name', '');
		$type = Arr::get($_POST, 'type', '');
		$staffId = Arr::get($_POST, 'staff_id', 0);
		$password = Arr::get($_POST, 'password', '');
		$mobile = Arr::get($_POST, 'mobile', '');
		$phone = Arr::get($_POST, 'phone', '');
		$loginType = Arr::get($_POST, 'login_type', 0);

		// 数据合法性检测
		$errors = array();
		if (!Valid::not_empty($managerId)) {
			$errors[] = '用户ID不能为空！';
		}
		$manager = BLL::Manager()->getManagerByManagerId($managerId)->getObject('Model_Manager');
		if (count($manager) < 1) {
			$errors[] = '用户不存在！';
		}
		if (!Valid::not_empty($givenName)) {
			$errors[] = '姓名不能为空！';
		}
		if (!Valid::not_empty($type)) {
			$errors[] = '请选择员工类型！';
		} else {
			if ($type == Dao_Manager::TYPE_FULLTIME) {
				if (!Valid::not_empty($staffId)) {
					$errors[] = '请填写员工号！';
				} elseif(!Valid::digit($staffId)) {
					$errors[] = '员工号格式不正确！';
				}
			}
		}
		if($mobile && !Valid::phone($mobile)) {
			$errors[] = '手机号格式不正确！';
		}
		if ($errors) {
			return Misc::jsonError($errors);
		}

		// 管理员信息入库
		$values = array(
			'given_name' => $givenName,
			'type' => $type,
			'staff_id' => $staffId,
			'phone' => $phone,
			'mobile' => $mobile,
			'weibo_uid' => 0,
			'approve_status' => Dao_Manager::STATUS_APPROVE_SUCCESS,
			'login_type' => Dao_Manager::LOGIN_TYPE_TODO
		);
		if (Valid::not_empty($password)) {
			$values['password'] = md5($password);
		}
		try {
			$result = BLL::Manager()->updateByManagerId($managerId, $values)->getArray();
			if (!Valid::not_empty($result)) {
				$errors[] = '设置失败！';
			}
		} catch(Exception $e) {
			$errors[] = $e->getMessage();
		}
		if ($errors) {
			Logger_Client::behaviorLog(implode("\t", $errors));
			return Misc::jsonError($errors);
		}
		Logger_Client::behaviorLog('个人设置 '.$managerId.' 成功');
		return Misc::jsonSuccess('设置成功！', URL::site('/main'));
	}

	/**
	 * 个人资料
	 */
	public function action_profileInfo() {
		$this->_autoRender = false;

		$managerId = Manager::managerId();
		$errors = array();
		if (!Valid::not_empty($managerId)) {
			$errors[] = '用户ID为空！';	
		}
		if ($errors) {
			return Misc::message(implode(',', $errors), '/default');
		}
		$manager = BLL::Manager()->getManagerByManagerId($managerId)->getObject('Model_Manager');
		if (!Valid::not_empty($manager)) {
			$errors[] = '用户不存在！';
		}
		if ($errors) {
			return Misc::message(implode(',', $errors), '/default');
		}
		// 获取所有角色
		$roles = BLL::Role()->getRoles()->getObject('Model_Role');
		// 获取管理员和角色对应关系
		$managerRoleMap = BLL::Role_Manager()->getAllByManagerId($managerId)->getArray();
		$layout = View::factory('layouts/layer');
		$layout->content = View::factory('manager/profile/info')
			->set('roles', $roles)
			->set('managerRoleMap', $managerRoleMap)
			->set('manager', $manager->current());
		$this->response->body($layout->render());
	}
}
