<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 日志写入类
 */
class Logger {
    /**
     * 全局访问实例变量
     */
    protected static $_instance = null;

    /**
     * 是否立即写入
     */
    public static $_write_on_add = false;

	/**
	 * 单例
	 */
	public static function getInstance() {
        if (Logger::$_instance === null) {
            Logger::$_instance = new Logger();
            // Write the logs at shutdown
            register_shutdown_function(array(Logger::$_instance, 'write'));
        }
        return Logger::$_instance;
	}

	/**
	 * 存放即将写入的日志数据
	 * @var Logger_Message
	 */
	protected $_messages = array();

	/**
	 * 日志数据进行持久化的设备，支持同时持久化多个设备
	 * @var Logger_Device
	 */
	protected $_writers = array();

    private function __construct() {}

    /**
     * 挂载设备
     * @param Logger_Device $device
     */
    public function attach(Logger_Writer $writer) {
        if ($writer instanceof Logger_Writer) {
            $this->_writers[spl_object_hash($writer)] = $writer;
        } else {
            throw new Logger_Exception('挂载设备数据类型错误！');
        }
        return $this;
    }

    /**
     * 撤销挂载设备
     * @param Logger_Device $device
     */
    public function detach(Logger_Writer $writer) {
        unset($this->_writers[spl_object_hash($writer)]);
        return $this;
    }
    
    /**
     * 添加写入数据
     * @param Logger_Message $message
     */
	public function add(Logger_Message $message) {
        if ($message instanceof Logger_Message) {
            $this->_messages[] = $message;
        } else {
            throw new Logger_Exception('写入消息数据类型错误。');
        }
        if (Logger::$_write_on_add) {
            $this->write();
        }
        return $this;
    }

    /**
     * 执行写入日志
     */
	public function write() {
        if (empty($this->_messages)) {
            return;
        }

   		// Import all messages locally
		$messages = $this->_messages;

		// Reset the messages array
		$this->_messages = array();
    
        foreach($this->_writers as $writer) {
            foreach ($messages as $message) {
                $writer->write($message);
            }
        }
    }
}
