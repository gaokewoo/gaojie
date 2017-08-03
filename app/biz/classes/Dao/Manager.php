<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理员Dao层
 */
class Dao_Manager extends Dao {

	protected $_db = 'admin';

	protected $_tableName = 'manager';

	protected $_primaryKey = 'manager_id';

	/**
	 * 管理员状态，正常状态
	 */
	const STATUS_NORMAL = 0;

	/**
	 * 管理员状态，已删除状态(禁用状态)
	 */
	const STATUS_DELETED = -1;

	/**
	 * 管理员状态,禁用状态
	 */
	const STATUS_DISABLE = 1;
	/**
	 * 审核中
	 */
	const STATUS_APPROVE_ING = 0;

	/**
	 * 通过审核
	 */
	const STATUS_APPROVE_SUCCESS = 1;

	/**
	 * 未通过审核
	 */
	const STATUS_APPROVE_FAILED = -1;

	/**
	 * 正式职工
	 */
	const TYPE_FULLTIME = 0;

	/**
	 * 实习生
	 */
	const TYPE_INTERN = 1;

	/**
	 * 兼职
	 */
	const TYPE_PARTTIME = 2;

	/**
	 * 合作方
	 */
	const TYPE_PARTNER = 3;

	/**
	 * Staff登录
	 */
	const LOGIN_TYPE_STAFF = 1;

	/**
	 * 密码登录
	 */
	const LOGIN_TYPE_LOCAL = 2;

	/**
	 * 未选择登录方式
	 */
	const LOGIN_TYPE_TODO = 0;
	
	/**
	 * sso登录
	 */
	const MANAGER_TYPE_SSO= 3;
	
	/**
	 * 机构登录方式
	 */
	const LOGIN_TYPE_TEAM = 3;

	/**
	 * 插入一条
	 * @param  array  $values
	 * @return integer
	 */
	public function insert(array $values) {
		return DB::insert($this->_tableName)
			->columns(array_keys($values))
			->values(array_values($values))
			->execute($this->_db);
	}

	/**
	 * 根据用户ID更新用户信息
	 * @param  integer $managerId 用户ID
	 * @param  array   $values 要更新的用户信息
	 * @return array
	 */
	public function updateByManagerId($managerId, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, '=', $managerId);

		return $query->execute($this->_db);
	}

	/**
	 * 根据uid修改Manager表中的名称
	 */
	public function updateManagerByUid($uid, $values) {
		$select = DB::update($this->_tableName)
		    ->set($values)
			->where('weibo_uid', '=', $uid);
			
		return $select->execute($this->_db);    
	}

	/**
	 * 更新用户
	 * @param  array $managerIds 用户id
	 * @param  array $values     更改值
	 * @return boolean
	 */
	public function updateByManagerIds($managerIds, $values) {
		$query = DB::update($this->_tableName)
			->set($values)
			->where($this->_primaryKey, 'IN', $managerIds);

		return $query->execute($this->_db);
	}

	/**
	 * 根据用户ID查找用户
	 * @param  integer $managerId 用户ID
	 * @return array
	 */
	public function getManagerByManagerId($managerId) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, '=', $managerId)
			->where('status', '=', self::STATUS_NORMAL)
			->where('approve_status', '=', self::STATUS_APPROVE_SUCCESS);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据用户ID查找用户
	 * @param  array $managerIds 用户ID
	 * @return array
	 */
	public function getManagersByManagerIds($managerIds) {
		$query = DB::select()
			->from($this->_tableName)
			->where($this->_primaryKey, 'IN', $managerIds)
			->where('status', '!=', self::STATUS_DELETED)
			->where('approve_status', '=', self::STATUS_APPROVE_SUCCESS);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据邮箱搜索用户信息
	 * @param  string $email 邮箱
	 * @return array
	 */
	public function getManagerByEmail($email) {
		$query = DB::select()
			->from($this->_tableName)
			->where('email', '=', $email)
			->where('status', '=', self::STATUS_NORMAL)
			->where('approve_status', '=', self::STATUS_APPROVE_SUCCESS);

		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 查找所有用户
	 * @param integer $offset 开始位置
	 * @param integer $number 步长
	 * @return array
	 */
	public function getManagers($offset = 0, $number = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->and_where('login_type', '!=', self::LOGIN_TYPE_TEAM);
		if($offset) {
			$query->offset($offset);
		}
		if($number) {
			$query->limit($number);
		}
		// echo Debug::vars((string) $query);exit();
		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 获取用户总数
	 */
	public function getCountManagers() {
		$query = DB::select(DB::expr('COUNT(*) AS recordCount'))
			->from($this->_tableName);

		return $query->execute($this->_db)->get('recordCount');
	}

	/**
	 * 根据关键字查找用户
	 * @param  string  $keyword 关键字
	 * @param  integer $offset  开始位置
	 * @param  integer $number  步长
	 * @return array
	 */
	public function getManagersByKeyword($keyword = '', $offset = 0, $number = 0) {
		$query = DB::select()
			->from($this->_tableName)
			->order_by($this->_primaryKey, 'DESC');

		if ($keyword) {
			$query->and_where_open();
			$query->where($this->_primaryKey, '=', $keyword);
			$query->or_where('given_name', 'LIKE', '%'.$keyword.'%');
			$query->or_where('email', 'LIKE', '%'.$keyword.'%');
			$query->or_where('mobile', '=', $keyword);
			$query->and_where_close();
		}

		if($offset) {
			$query->offset($offset);
		}
		if($number) {
			$query->limit($number);
		}
		$query->and_where('login_type', '!=', self::LOGIN_TYPE_TEAM);
		return $query->execute($this->_db)->as_array();
	}

	/**
	 * 根据关键字查找用户总数
	 * @param  string $keyword 关键字
	 * @return array
	 */
	public function getCountManagersByKeyword($keyword = '') {
		$query = DB::select(DB::expr('COUNT(*) AS recordCount'))
			->from($this->_tableName);

		if ($keyword) {
			$query->where($this->_primaryKey, '=', $keyword);
			$query->or_where('given_name', 'LIKE', '%'.$keyword.'%');
			$query->or_where('email', 'LIKE', '%'.$keyword.'%');
			$query->or_where('mobile', '=', $keyword);
		}

		return $query->execute($this->_db)->get('recordCount');
	}

	/**
	 * 根据微博uid和loginType检索Manager表中信息
	 */
	public function getManagerByUidAndLoginType($uid, $loginType) {
		$select = DB::select('*')
			->from($this->_tableName)
			->where('weibo_uid', '=', $uid)
			->and_where('login_type', '=', $loginType);
		return $select->execute($this->_db)
			->as_array();
	}
	
	/**
	 * 根据微博UID查找管理员
	 * @param integer $uid
	 * @param integer $loginType
	 */
	public function getManagerByUid($uid, $loginType = Dao_Manager::MANAGER_TYPE_SSO) {
		$select = DB::select()
			->from($this->_tableName)
			->where('weibo_uid', '=', $uid)
			->where('login_type', '=', $loginType)
			->where('status', '=', self::STATUS_NORMAL);
		return $select->execute($this->_db)->as_array();
	}
}
