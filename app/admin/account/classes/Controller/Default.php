<?php defined('SYSPATH') or die('No direct script access.');

/**
 * default controller
 */
class Controller_Default extends Controller {
	protected $_adminName= 'app';
	/**
	 * Login Page
	 */
	public function action_index() {
		$adminName = $this->_adminName;
		$config = Kohana::$config->load(strtolower($adminName));
		View::set_global('adminConfig', $config);
		View::set_global('resourcePath', isset($config['resource_path']) ? $config['resource_path'] : '');
        $content = View::factory('manager/login')
            ->render();
        $this->response->body($content);
	}

     /**
     * Login authentication
     */
    public function action_login() {
            $username = Arr::get($_POST, 'username');
            $password = Arr::get($_POST, 'password');

            $logined = false;
            try {
                    $logined = Manager::instance()->localLogin($username, $password);
            } catch(Exception $e) {
                    return Misc::jsonError($e->getMessage(), '/default');
            }
            if ($logined) {
                    $givenName = Manager::givenName();
                    Logger_Client::behaviorLog($givenName.' 登录成功');
                    return Misc::jsonSuccess('登录成功！', '/main');
            }
            return Misc::jsonError('抱歉，账号和密码错误，登录失败！', '/default');
    }

	/**
	 * 注销登录
	 */
	public function action_logout() {
		$adminName = $this->_adminName;
		$config = Kohana::$config->load(strtolower($adminName));
		try {
			$givenName = Manager::givenName();
            $return = Manager::instance()->logout();
			if($return) {
                return Controller::redirect('/default');
			}
		} catch(Author_Exception $e) {
			return Misc::message($e->getMessage(), 'author');
		}
	}
	
	/**
	 * 申请登录权限
	 */
	public function action_register() {
		$content = View::factory('manager/register')
			->render();
		$this->response->body($content);
	}
	
}
