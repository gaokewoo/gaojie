<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 日志消息基类
 * 
 */
abstract class Logger_Message {

    /**
     * Get an array of the message
     * 
     * @return array
     */
    abstract public function getMessage();

}
