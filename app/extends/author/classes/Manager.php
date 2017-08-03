<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 用户类
 */
class Manager {
	protected static $_instance = null;

	public static function instance() {
		if (self::$_instance === null) {
			$config = Kohana::$config->load('manager')->as_array();
			self::$_instance = new self($config);
		}
		return self::$_instance;
	}

	public static function managerId() {
		return Manager::instance()->getManagerId();
	}

	public static function email() {
		return Manager::instance()->getEmail();
	}

	public static function givenName() {
		return Manager::instance()->getGivenName();
	}
	
	public static function uid() {
		return Manager::instance()->getUid();
	}

	public static function roles() {
		return Manager::instance()->getRoles();
	}

	public static function privileges() {
		return Manager::instance()->getPrivileges();
	}
	
	/**
	 * 账号默认角色（普通账号）
	 */
	const ROLE_NORMAL_USER = 3;

	/**
	 * 账号类型-正式职工
	 */
	const TYPE_FULLTIME = 0;

	/**
	 * 账号类型-实习生
	 */
	const TYPE_INTERN = 1;

	/**
	 * 账号类型-兼职
	 */
	const TYPE_PARTTIME = 2;

	/**
	 * 账号类型-合作方
	 */
	const TYPE_PARTNER = 3;

	/**
	 * 管理员账号审核中
	 */
	const STATUS_APPROVE_ING = 0;

	/**
	 * 管理员账号通过审核
	 */
	const STATUS_APPROVE_SUCCESS = 1;

	/**
	 * 管理员账号未通过审核
	 */
	const STATUS_APPROVE_FAILED = -1;

	/**
	 * 用户ID
	 * @var integer
	 */
	protected $_managerId = 0;

	/**
	 * 用户邮箱
	 * @var string
	 */
	protected $_email = '';

	/**
	 * 姓名
	 * @var string
	 */
	protected $_given_name = '';

	/**
	 * 用户角色
	 * @var null
	 */
	protected $_roles = null;
	
	/**
	 * uid
	 * @var integer
	 */
	protected $_uid = '';

	/**
	 * 用户权限
	 * @var null
	 */
	protected $_privileges = null;
	
	protected $_team_id = null;

	/**
	 * 相关配置信息
	 * @var null
	 */
	protected $_config = null;

	/**
	 * 域名
	 * @var string
	 */
	protected $_host = null;

	public function __construct($config = null) {
		if ($config == null) {
			throw new Author_Exception('缺少配置文件manager.php');
		}
		$this->_config = $config;
		$this->_host = Kohana::$config->load('default.host');

		$manager = Session::instance()->get('manager', array());
		if (isset($manager['manager_id'])) {
			$this->_managerId = $manager['manager_id'];
		}
		if (isset($manager['email'])) {
			$this->_email = $manager['email'];
		}
		if (isset($manager['given_name'])) {
			$this->_given_name = $manager['given_name'];
		}
		if(isset($manager['weibo_uid'])) {
			$this->_uid = $manager['weibo_uid'];
		}
    }

	/**
	 * 判断是否已经登录
	 * 
	 * $encrypt = new Encrypt($key, $mode, $cipher);
	 * $passport = $encrypt->encode(name@md5(ua.ip.password));
	 * 
	 * @return boolean
	 */
	public function isLogin() {
		$passport = Cookie::get($this->_config['passport'], NULL);
		if($passport === NULL) {
			return FALSE;
		}
		
		$encrypt = new Encrypt($this->_config['key'], $this->_config['mode'], $this->_config['cipher']);
		$text = $encrypt->decode($passport);
		$pairs = explode('|*|*|', $text);
		$email = $pairs[0];
		$identifier = $pairs[1];
		
		$manager = Session::instance()->get('manager', array());
		if(!isset($manager['email']) || $email !== $manager['email']) {
			$manager = BLL::Manager()->getManagerByEmail($email)->getObject('Model_Manager');
			if(!$manager) {
				throw new Author_Exception('获取账户信息失败！');
			}
			$manager = $manager->current();
			if($identifier != md5(Request::$user_agent.Request::$client_ip.$manager->getPassword())) { 
				throw new Author_Exception('登录失效！');
			}
			$this->_managerId = $manager->getAccountId();
			$this->_name = $manager->getName();
			$this->_given_name = $manager->getGivenName();
			$this->_uid = $manager->getWeiboUid();
			Session::instance()->set('manager', $manager->asArray());
		}
		return TRUE;
	}

    /**
     * 本地登录
     * @param $name string
     * @param $password string
     *
     * @return boolean
     */
    public function localLogin($email, $password) {
            $result = BLL::Manager()->getManagerByEmail($email)->getObject('Model_Manager');

            if(!$result->count()) {
                    return FALSE;
            }
            $manager = $result->current();
            if($manager->getPassword() != md5($password)) {
                    return FALSE;
            }
            if($manager->getStatus() == -1) {
                    throw new Author_Exception('登录失败，帐号已被屏蔽');
            }

            $this->_managerId = $manager->getManagerId();
            $this->_email = $email;
            $this->_given_name = $manager->getGivenName();
            Session::instance()->set('manager', $manager->asArray());

            $encrypt = new Encrypt($this->_config['key'], $this->_config['mode'], $this->_config['cipher']);
            $identifier = md5(Request::$user_agent.Request::$client_ip.$manager->getPassword());
            $passport = $encrypt->encode($email.'|*|*|'.$identifier);

            Cookie::set($this->_config['passport'], $passport);
            return TRUE;
    }

	/**
	 * 注销登录
	 * @return boolean
	 */
	public function logout() {
		Cookie::delete($this->_config['passport']);
		Session::instance()->delete('manager');
		return Cookie::get($this->_config['passport']) ? false : true;
	}

	public function getManagerId() {
		return $this->_managerId;
	}

	public function getEmail() {
		return $this->_email;
	}

	public function getGivenName() {
		return $this->_given_name;
	}
	
	public function getUid() {
		return $this->_uid;
	}
	
	public function getRoles() {
		if ($this->_roles === null) {
			$this->_roles = BLL::Manager()->getManagerRoles($this->_managerId)->getObject('Model_Role');
		}
		return $this->_roles;
	}

	public function getPrivileges() {
		if ($this->_privileges === null) {
			$this->_privileges = BLL::Manager()->getManagerPrivileges($this->_managerId)->getObject('Model_Privilege');
		}
		return $this->_privileges;
	}
	
}
