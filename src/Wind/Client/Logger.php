<?php

/**
 * @file
 * PSR-3 Logger implementation. 
 * 
 * The Client\Logger sends the log to the Wind server, which in turn will
 * persist the log.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Client;

use Wind\Server\Router;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

class Logger extends AbstractLogger
{
    /**
     * @var The host where Wind is hosted.
     */
    protected $server;
    
    /**
     * @var A router implementing the Wind server router interface.
     */
    protected $router;
   
    /**
     * Constructor.
     * 
     * Give it the path to the Wind server, example: http://localhost:7666.
     * 
     * @param string $server
     */
    public function __construct($server, RouterInterface $router)
    {
        // Make sure we end with a slash.
        if (!preg_match('/\/$/', $server)) {
            $server .= '/';
        }
        $this->server = $server;
        $this->router = $router;
    }
    
    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array()) 
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
            case LogLevel::WARNING:
            case LogLevel::NOTICE:
            case LogLevel::INFO:
            case LogLevel::DEBUG:
                $params = array(
                    'message' => $message,
                    'context' => $context,
                );
                $path = $this->router->getRouteFromLogLevel($level);
                $this->send($path, $params);
                break;
            
            default:
                throw new InvalidArgumentException("Got a log level not specified by the PSR-3 standard. Log level received: $level.");
                break;
        }    
    }
  
    /**
     * Sends the data to the Wind server.
     * 
     * @param string $path
     * @param array $params
     */
    protected function send($path, array $params)
    {
        $ch = curl_init($this->server . $path);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_exec($ch);
        curl_close($ch);
    }
}