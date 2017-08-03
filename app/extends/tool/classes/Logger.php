<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 通用日志类
 * 支持日志同时调用多个Writer
 * 支持自定义日志数据
 * 
 */
class Logger {

    /**
     * @var  Logger  Singleton instance container
     */
    protected static $_instance = null;

    /**
     * Get the singleton instance of this class and enable writing at shutdown.
     *
     *     $logger = Logger::instance();
     *
     * @return  Logger
     */
    public static function instance() {
        if (Logger::$_instance === null) {
            // Create an instance
            Logger::$_instance = new Logger();

            // Write the logs at shutdown
            register_shutdown_function(array(Logger::$_instance, 'write'));
        }

        return Logger::$_instance;
    }

    /**
     * List of log messages
     * 
     * @var array
     */
    protected $_messages = array();

    /**
     * List of log writers
     * 
     * @var array
     */
    protected $_writers = array();

    /**
     * Attaches a log writer.
     *
     *     $logger->attach($writer);
     *
     * @param   Log_Writer  $writer     instance
     * @return  Logger
     */
    public function attach(Logger_Writer $writer) {
        $this->_writers["{$writer}"] = $writer;

        return $this;
    }

    /**
     * Detach a log writer.
     *
     *     $logger->detach($writer);
     *
     * @param   Log_Writer  $writer     instance
     * @return  Logger
     */
    public function detach(Logger_Writer $writer) {
        unset($this->_writers["{$writer}"]);

        return $this;
    }

    /**
     * Add message
     *
     *     $logger->add($message);
     *      
     * @param Logger_Message $message instance
     * @return Logger
     */
    public function add(Logger_Message $message) {
        $this->_messages[] = $message;

        return $this;
    }

    /**
     * Write and clear all the messages
     *
     *     $logger->write();
     * 
     * @return void
     */
    public function write() {
        if (empty($this->_messages)) {
            return;
        }

        if (empty($this->_writers)) {
            return;
        }

        // Import all message locally
        $messages = $this->_messages;

        // Reset the messages array
        $this->_messages = array();

        foreach ($this->_writers as $writer) {
            $writer->write($messages);
        }
    }
}
