<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 日志写入器基类
 * 
 */
abstract class Logger_Writer {

    /**
     * Write the array of messages
     * @param  Array  $messages
     * @return void
     */
    abstract public function write(Array $messages);

    /**
     * Allows the writer to have a unique key when stored.
     *
     *     echo $writer;
     *
     * @return  string
     */
    final public function __toString()
    {
        return spl_object_hash($this);
    }
}
