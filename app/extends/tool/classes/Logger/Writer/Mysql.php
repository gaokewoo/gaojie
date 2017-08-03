<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mysql日志写入器类
 * 
 */
class Logger_Writer_Mysql extends Logger_Writer {

    // Database instance
    private $_db;

    // The database group
    private $_group = 'admin';

    // The table name
    private $_table = 'log_crash';

    private $_columns = array(
        'log_crash_id' => 'log_crash_id',
        'ip'           => 'ip',
        'hostname'     => 'hostname',
        'level'        => 'level',
        'file'         => 'file',
        'line'         => 'line',
        'message'      => 'message',
        'trace'        => 'trace',
        'create_time'  => 'create_time'
    );

    public function __construct() {
        // load config
        $config = Kohana::$config->load('log.database');

        if (isset($config['group'])) {
            $this->_group = $config['group'];
        }

        // create a database instance
        $this->_db = Database::instance($this->_group);

        if (isset($config['table'])) {
            $this->_table = $config['table'];
        }

        if (isset($config['columns'])) {
            $this->_columns = $config['columns'];
        }
        array_shift($this->_columns);
    }

    /**
     * Writes each of the messages into the `log_crash`
     *
     *     $writer->write($messages);
     *
     * @param   array   $messages
     * @return  void
     */
    public function write(array $messages) 
    {
        // Insert a new row
        $query = DB::insert($this->_table, $this->_columns)
            ->values(array(':ip', ':hostname', ':level', ':file', ':line', ':message', ':trace', ':create_time'));
            
        foreach ($messages as $message) {
            $ip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : '';
            $hostname = isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : '';
            $level = $this->_log_levels[$message['level']];
            $file = $message['file'];
            $line = $message['line'];
            $body = $message['body'];
            $trace = $this->format_message($message);
            $createTime = $message['time'];

            $query
                ->param(':ip', $ip)
                ->param(':hostname', $hostname)
                ->param(':level', (string)$level)
                ->param(':file', (string)$file)
                ->param(':line', (int)$line)
                ->param(':message', (string)$body)
                ->param(':trace', (string)$trace)
                ->param(':create_time', (int)$createTime);

            list($insertId, $affectedRows) = $query->execute($this->_db);
            if (!$insertId || $affectedRows <= 0) {
                return false;
            }
        }

        return true;
    }

}
