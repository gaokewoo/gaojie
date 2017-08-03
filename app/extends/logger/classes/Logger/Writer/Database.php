<?php
/**
 * MySql数据库写入库
 */
class Logger_Writer_Database extends Logger_Writer {

    public function write(Logger_Message $message) {
        $msg = $message->getMessage();
        $msgName = $message->getName();

        if (empty($msgName) || empty($msg)) {
            return;
        }

        $msgDbMap = Kohana::$config->load('logger.msgDbMap');
        $database = $msgDbMap[$msgName]['db'];
        $table    = $msgDbMap[$msgName]['table'];

        $query = DB::insert($table)
   			->columns(array_keys($msg))
			->values(array_values($msg));
        
        $result = $query->execute($database);
    }
}