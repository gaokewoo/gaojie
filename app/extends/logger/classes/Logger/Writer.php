<?php
/**
 * 日志写入器基类
 */
abstract class Logger_Writer {
    abstract public function write(Logger_Message $message);
}