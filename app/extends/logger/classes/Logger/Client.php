<?php
/**
 * 日志客户端
 */
class Logger_Client {
    /**
     * 记录行为日志
     */
    public static function behaviorLog($message) {
        $logger = Logger::getInstance();
        $writer = new Logger_Writer_Database();
        $logger->attach($writer);
        $message = new Logger_Message_Behavior($message);
        $logger->add($message);
    }
}