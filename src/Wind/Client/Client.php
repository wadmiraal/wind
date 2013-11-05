<?php

/**
 * @file
 */

namespace Wind\Client;

class Client
{
    /**
     * @var The host where Wind is hosted. Example: http://localhost:7666.
     */
    protected $server;
  
    /**
     * @var The list of data.
     */
    protected $logs;
   
    /**
     * Constructor...
     */
    public function __construct($server)
    {
        $this->server = $server;
        $this->logs = array();
    }
  
    /**
     * Logs the data.
     * 
     * By default, all logs are kept in memory and only sent when flush() is called.
     * If you want to send the data to the Wind server directly, pass true as the second
     * parameter.
     * 
     * @param  array|object $data
     *         The data to send to the log server. Can be any data structure understandable
     *         by the json_encode function.
     * @param  bool $send = false
     *         Set this to true to send the data to the server directly. This will also send
     *         all other pending logs.
     */
    public function log($data, $send = false)
    {
        $this->logs[] = $data;
      
        if ($send) {
            $this->flush();
        }
    }
  
    /**
     * Send the pending logs to the server to persist the data.
     */
    public function flush()
    {
        if (!empty($this->logs)) {
            $json = json_encode($this->logs);
            $this->send($json);
            $this->logs = array();
        }
    }
  
    /**
     * Sends the data to the Wind server using cURL.
     * 
     * @param  string $json
     *         The JSON data to send to the Wind server.
     */
    protected function send($json)
    {
      // ...
    }
}