<?php
/**
 * 日志文件写入器
 */
class Logger_Writer_File extends Logger_Writer {

    public function write(Logger_Message $message) {
        $fileName = $message->getName();
        $message  = $message->getMessage();

        if (empty($fileName) || empty($message)) {
            return;
        }

        $file = APPPATH.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR.$fileName;
        file_put_contents($file, serialize($message), FILE_APPEND);
    }
}