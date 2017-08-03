<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理员业务逻辑层
 */
class Business_Manager extends Business {

	/**
	 * 添加管理员
	 * @param  array  $value 
	 * @return array
	 */
	public function create($values = array ()) {

		$fields = array (
			'given_name' => '',
			'password' => '',
			'type' => 0,
			'staff_id' => 0,
			'email' => '',
			'phone' => '',
			'mobile' => '',
			'weibo_uid' => '',
			'approve_status' => Dao_Manager::STATUS_APPROVE_ING,
			'login_type' => Dao_Manager::LOGIN_TYPE_TODO,
			'status' => Dao_Manager::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		$values = $values + $fields;

		return Dao::factory('Manager')->insert($values);
	}

	/**
	 * 更新用户信息
	 * @param  integer $managerId 用户ID
	 */
	public function updateByManagerId($managerId, $values) {
		$errors = array();
		if (!$managerId || !$values) {
			$errors[] = '参数不正确！';
		}
		$fields = array (
			'given_name' => '',
			'password' => '',
			'type' => 0,
			'staff_id' => 0,
			'email' => '',
			'phone' => '',
			'mobile' => '',
			'weibo_uid' => '',
			'approve_status' => Dao_Manager::STATUS_APPROVE_ING,
			'login_type' => Dao_Manager::LOGIN_TYPE_TODO,
			'status' => Dao_Manager::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		);
		$values = array_intersect_key($values, $fields);
		if (count($values) < 1) {
			$errors[] = '没有要被更新的字段';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		return Dao::factory('Manager')->updateByManagerId($managerId, $values);
	}

	/**
	 * 通过uid修改Manager表中名称
	 */
	public function updateManagerByUid($uid, $values) {
		
		$fields = array (
			'given_name' => '',
			'password' => '',
			'type' => 0,
			'staff_id' => 0,
			'email' => '',
			'phone' => '',
			'mobile' => '',
			'weibo_uid' => '',
			'approve_status' => Dao_Manager::STATUS_APPROVE_ING,
			'login_type' => Dao_Manager::LOGIN_TYPE_TEAM,
			'status' => Dao_Manager::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		);

		$values = array_intersect_key($values, $fields);
		return Dao::factory('Manager')->updateManagerByUid($uid, $values);
	}

	/**
	 * 更新用户
	 * @param  array $managerIds 用户id
	 * @param  array $values     更改值
	 * @return boolean
	 */
	public function updateByManagerIds($managerIds, $values) {
		$errors = array();
		if (!$managerIds || !$values) {
			$errors[] = '参数不正确！';
		}
		$fields = array (
			'given_name' => '',
			'password' => '',
			'type' => 0,
			'staff_id' => 0,
			'email' => '',
			'phone' => '',
			'mobile' => '',
			'weibo_uid' => '',
			'approve_status' => Dao_Manager::STATUS_APPROVE_ING,
			'login_type' => Dao_Manager::LOGIN_TYPE_TODO,
			'status' => Dao_Manager::STATUS_NORMAL,
			'create_time' => time(),
			'update_time' => time(),
		);
		$values = array_intersect_key($values, $fields);
		if (count($values) < 1) {
			$errors[] = '没有要被更新的字段';
		}
		if ($errors) {
			throw new Business_Exception(implode(',', $errors));
		}

		return Dao::factory('Manager')->updateByManagerIds($managerIds, $values);
	}

	/**
	 * 根据邮箱查找用户
	 * @param  string $email 邮箱
	 * @return array         用户信息
	 */
	public function getManagerByEmail($email) {
		if (!$email) {
			return array();
		}
		return Dao::factory('Manager')->getManagerByEmail($email);
	}

	/**
	 * 根据用户ID查找用户
	 * @param  integer $managerId 用户ID
	 * @return array
	 */
	public function getManagerByManagerId($managerId) {
		if (!$managerId) {
			return array();
		}
		return Dao::factory('Manager')->getManagerByManagerId($managerId);
	}

	/**
	 * 根据用户ID查找用户
	 * @param  array $managerIds 用户ID
	 * @return array
	 */
	public function getManagersByManagerIds($managerIds) {
		if (!Valid::not_empty($managerIds)) {
			return array();
		}
		return Dao::factory('Manager')->getManagersByManagerIds($managerIds);
	}

	/**
	 * 查找所有用户
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getManagers($offset = 0, $number = 0) {
		$managers = Dao::factory('Manager')->getManagers($offset, $number);
		$managerIds = array();
		foreach ($managers as $manager) {
			if ($manager['manager_id']) {
				array_push($managerIds, $manager['manager_id']);
			}
		}

		if (!Valid::not_empty($managers)) {
			return array();
		}

		// 获取所有角色ID
		$managerIdAndRoleIdMaps = Dao::factory('Role_Manager')->getAllByManagerIds($managerIds);
		$roleIds = array();
		foreach ($managerIdAndRoleIdMaps as $item) {
			array_push($roleIds, $item['role_id']);
		}
		$roleIds = array_unique($roleIds);

		$managerIdAndRolesMaps = array();
		if (count($roleIds) > 0) {
			// 获取角色信息
			$roles = Dao::factory('Role')->getRolesByRoleIds($roleIds);
			$rolesMaps = array();
			foreach ($roles as $role) {
				$rolesMaps[$role['role_id']] = $role['name'];
			}

			foreach ($managerIdAndRoleIdMaps as $item) {
				if (isset($rolesMaps[$item['role_id']]) && $rolesMaps[$item['role_id']]) {
					$managerIdAndRolesMaps[$item['manager_id']][] = $rolesMaps[$item['role_id']];
				}
			}
		}

		// 将角色添加至用户信息中
		foreach ($managers as $key => $manager) {
			$managers[$key]['roles'] = isset($managerIdAndRolesMaps[$manager['manager_id']]) ? implode(',', $managerIdAndRolesMaps[$manager['manager_id']]) : '';
		}

		return $managers;
	}

	/**
	 * 获取管理员个数
	 */
	public function getCountManagers() {
		return Dao::factory('Manager')->getCountManagers();
	}

	/**
	 * 根据关键字查找用户
	 * @param  string  $keyword 关键字
	 * @param  integer $offset  开始位置
	 * @param  integer $number  步长
	 * @return array
	 */
	public function getManagersByKeyword($keyword = '', $offset = 0, $number = 0) {
		$managers = Dao::factory('Manager')->getManagersByKeyword($keyword, $offset, $number);
		$managerIds = array();
		foreach ($managers as $manager) {
			if ($manager['manager_id']) {
				array_push($managerIds, $manager['manager_id']);
			}
		}

		if (!Valid::not_empty($managers)) {
			return array();
		}

		// 获取所有角色ID
		$managerIdAndRoleIdMaps = Dao::factory('Role_Manager')->getAllByManagerIds($managerIds);
		$roleIds = array();
		foreach ($managerIdAndRoleIdMaps as $item) {
			array_push($roleIds, $item['role_id']);
		}
		$roleIds = array_unique($roleIds);

		$managerIdAndRolesMaps = array();
		if (count($roleIds) > 0) {
			// 获取角色信息
			$roles = Dao::factory('Role')->getRolesByRoleIds($roleIds);
			$rolesMaps = array();
			foreach ($roles as $role) {
				$rolesMaps[$role['role_id']] = $role['name'];
			}

			foreach ($managerIdAndRoleIdMaps as $item) {
				if (isset($rolesMaps[$item['role_id']]) && $rolesMaps[$item['role_id']]) {
					$managerIdAndRolesMaps[$item['manager_id']][] = $rolesMaps[$item['role_id']];
				}
			}
		}

		// 将角色添加至用户信息中
		foreach ($managers as $key => $manager) {
			$managers[$key]['roles'] = isset($managerIdAndRolesMaps[$manager['manager_id']]) ? implode(',', $managerIdAndRolesMaps[$manager['manager_id']]) : '';
		}

		return $managers;
	}

	/**
	 * 根据关键字查找用户总数
	 * @param  string $keyword 关键字
	 * @return array
	 */
	public function getCountManagersByKeyword($keyword = '') {
		return Dao::factory('Manager')->getCountManagersByKeyword($keyword);
	}

	/**
	 * 获取用户角色
	 * @param  integer $managerId 用户ID
	 * @return array
	 */
	public function getManagerRoles($managerId) {
		if (!Valid::not_empty($managerId)) {
			return array();
		}
		$roleIds = array();
		$roleManagerMaps = Dao::factory('Role_Manager')->getAllByManagerId($managerId);
		foreach ($roleManagerMaps as $roleManagerMap) {
			array_push($roleIds, $roleManagerMap['role_id']);
		}
		$roles = array();
		if (Valid::not_empty($roleIds)) {
			$roles = Dao::factory('Role')->getRolesByRoleIds($roleIds);
		}
		return $roles;
	}

	/**
	 * 获取用户权限
	 * @param  integer $managerId 用户ID
	 * @return array
	 */
	public function getManagerPrivileges($managerId) {
		if (!Valid::not_empty($managerId)) {
			return array();
		}
		$roleIds = array();
		$roleManagerMaps = Dao::factory('Role_Manager')->getAllByManagerId($managerId);
		foreach ($roleManagerMaps as $roleManagerMap) {
			array_push($roleIds, $roleManagerMap['role_id']);
		}
		$privilegeIds = array();
		if (Valid::not_empty($roleIds)) {
			$rolePrivilegeMaps = Dao::factory('Role_Privilege')->getAllByRoleIds($roleIds);
			foreach ($rolePrivilegeMaps as $rolePrivilegeMap) {
				array_push($privilegeIds, $rolePrivilegeMap['privilege_id']);
			}
		}
		$privileges = array();
		if (Valid::not_empty($privilegeIds)) {
			$privileges = Dao::factory('Privilege')->getPrivilegeByPrivilegeIds($privilegeIds);
		}
		return $privileges;
	}
	
	/**
	 * 获取Manager表中对应的uid信息
	 */
	public function getManagerByUidAndLoginType($uid, $loginType) {
		return Dao::factory('Manager')->getManagerByUidAndLoginType($uid, $loginType);
	}
}
