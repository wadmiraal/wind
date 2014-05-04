<?php

/**
 * @file
 * Wind server router.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Wind\Server;

use Psr\Log\LogLevel;
use Wind\Server\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @const The emergency level route for the server.
     */
    const EMERGENCY = 'emergency';
    
    /**
     * @const The alert level route for the server.
     */
    const ALERT = 'alert';
    
    /**
     * @const The critical level route for the server.
     */
    const CRITICAL = 'critical';
    
    /**
     * @const The error level route for the server.
     */
    const ERROR = 'error';
    
    /**
     * @const The warning level route for the server.
     */
    const WARNING = 'warning';
    
    /**
     * @const The notice level route for the server.
     */
    const NOTICE = 'notice';
    
    /**
     * @const The info level route for the server.
     */
    const INFO = 'info';
    
    /**
     * @const The debug level route for the server.
     */
    const DEBUG = 'debug';
    
    /**
     * @inheritDoc
     */
    public function getRouteFromLogLevel($level)
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                return self::EMERGENCY;
            
            case LogLevel::ALERT:
                return self::ALERT;
            
            case LogLevel::CRITICAL:
                return self::CRITICAL;
            
            case LogLevel::ERROR:
                return self::ERROR;
            
            case LogLevel::WARNING:
                return self::WARNING;
            
            case LogLevel::NOTICE:
                return self::NOTICE;
            
            case LogLevel::INFO:
                return self::INFO;
            
            case LogLevel::DEBUG:
                return self::DEBUG;
            
            default:
                throw new \InvalidArgumentException("Got a log level not specified by the PSR-3 standard. Log level received: $level.");
                break;
        } 
    }
    
    /**
     * @inheritDoc
     */
    public function getLogLevelFromRoute($route)
    {
        switch ($route) {
            case self::EMERGENCY:
                return LogLevel::EMERGENCY;
            
            case self::ALERT:
                return LogLevel::ALERT;
            
            case self::CRITICAL:
                return LogLevel::CRITICAL;
            
            case self::ERROR:
                return LogLevel::ERROR;
            
            case self::WARNING:
                return LogLevel::WARNING;
            
            case self::NOTICE:
                return LogLevel::NOTICE;
            
            case self::INFO:
                return LogLevel::INFO;
            
            case self::DEBUG:
                return LogLevel::DEBUG;
            
            default:
                throw new \InvalidArgumentException("Got a route that does not match any log level. Route received: $route.");
                break;
        } 
    }
    
    /**
     * @inheritDoc
     */
    public function getRequestedPath()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];

            // Request URI contains host information.
            if (preg_match('/^https?:\/\//', $uri)) {
                if (!empty($_SERVER['HTTPS'])) {
                    $scheme = 'https';
                } else {
                    $scheme = 'http';
                }

                $host = $_SERVER['SERVER_NAME'];
                $port = $_SERVER['SERVER_PORT'];

                $uri = substr($uri, strlen("$scheme://$host:$port/"));
            } elseif (preg_match('/^\//', $uri)) {
                $uri = substr($uri, 1);
            }
            
            return $uri;
        } else {
            return '';
        }
    }
    
    /**
     * @inheritDoc
     */
    public function respond($body, $http_code = 302)
    {
        // todo.
        switch ($http_code) {
            case 204:
                header("HTTP/1.0 204 No Response");
                break;
            
            default:
                header("HTTP/1.0 302 Found");
                break;
        }
        echo $body;   
    }
    
    /**
     * @inheritDoc
     */
    public function getPost()
    {
        return $_POST;
    }
}