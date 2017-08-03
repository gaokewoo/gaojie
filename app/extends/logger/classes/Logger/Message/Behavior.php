<?php
/**
 * 后台行为日志消息类
 */
class Logger_Message_Behavior extends Logger_Message {
    /**
     * 日志消息类名称
     * 如果消息要写入数据库，请在配置文件中以该值为键值。
     * 参考：platy/config/development/logger.php
     */
    protected $_name = 'behavior_log';

    protected $_portal = '';

    protected $_controller = '';

    protected $_action = '';

    protected $_get = '';

    protected $_post = '';

    protected $_message = '';

    protected $_ip = '';

    protected $_user_agent = '';

    protected $_referer = '';

    protected $_manager_id = '';

    protected $_manager_name = '';

    protected $_create_time = 0;

    public function __construct($message = '') {
        $this->_portal = PORTAL;
        $this->_controller = Request::$current->controller();
        $this->_action = Request::$current->action();
        $this->_get = Request::$current->query() ? json_encode(Request::$current->query()) : '';
        $this->_post = Request::$current->post() ? json_encode(Request::$current->post()) : '';
        $this->_message = $message;
        $this->_ip = Request::$client_ip;
        $this->_user_agent = Request::$user_agent;
        $this->_referer = Request::$current->referrer() ? Request::$current->referrer() : '';
        $this->_manager_id = Manager::ManagerId();
        $this->_manager_name = Manager::givenName();
        $this->_create_time = time();
    }

    public function getMessage() {
        return array(
            'portal' => $this->_portal,
            'controller' => $this->_controller,
            'action' => $this->_action,
            'get' => $this->_get,
            'post' => $this->_post,
            'message' => $this->_message,
            'ip' => $this->_ip,
            'user_agent' => $this->_user_agent,
            'referer' => $this->_referer,
            'manager_id' => $this->_manager_id,
            'manager_name' => $this->_manager_name,
            'create_time' => $this->_create_time,
        );
    }

}
