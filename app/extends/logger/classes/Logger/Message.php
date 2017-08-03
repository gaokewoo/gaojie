<?php
/**
 * 日志消息基类
 */
abstract class Logger_Message {

    protected $_name = '';

    public function getName() {
        return $this->_name;
    }

    abstract public function getMessage();
}