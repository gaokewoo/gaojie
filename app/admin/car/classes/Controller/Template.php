<?php defined('SYSPATH') or die('No direct script access.');

/**
 * default controller
 */
class Controller_Template extends Controller {
	protected $_layout = 'layouts/default';
	
	protected $_autoRender = TRUE;
	
	protected $_loginURL = '';
	
	protected $_deniedURL = '';
	
	protected $_adminName = 'app';
	
	protected $_adminConfig = array();
	
	public function before() {
		$predefineName = Kohana::$config->load('default.adminName');
		if(isset(Kohana::$admin_name) && Kohana::$admin_name && in_array(Kohana::$admin_name, $predefineName)) {
			$this->_adminName = Kohana::$admin_name;
		}
		$serverHost = $_SERVER['HTTP_HOST'];
		
		$config = Kohana::$config->load(strtolower($this->_adminName));
		$host = $config['host'];
		if($host != $serverHost) {
			HTTP::redirect('http://' . $host.'/default');
		}
		$this->_loginURL = 'http://' . $host.'/default';
		$this->_deniedURL = 'http://' . $host.'/error?405';
		
		try {
			$logined = Manager::instance()->isLogin();
			if(!$logined) {
				return Controller::redirect($this->_loginURL);
			}
		} catch(Exception $e) {
			return Controller::redirect($this->_loginURL);
		}
		if(!ACL::access($this->request->controller(), $this->request->action())) {
			return Controller::redirect($this->_deniedURL);
		}
		$this->_adminConfig = $config;
		View::set_global('adminConfig', $config);
		View::set_global('resourcePath', isset($config['resource_path']) ? $config['resource_path'] : '');
		parent::before();
		if($this->_autoRender === TRUE) {
			$this->_layout = View::factory($this->_layout);
		}
	}
    
	public function after() {
		if($this->_autoRender === TRUE) {
			$this->response->body($this->_layout->render());
		}
		parent::after();
	}
}
