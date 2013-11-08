<?php

/**
 * @file
 * Wind server router.
 * 
 * ...
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Wind\Server;

use Psr\Log\LogLevel;

class Router
{
    const EMERGENCY = 'emergency';
    
    const ALERT = 'alert';
    
    const CRITICAL = 'critical';
    
    const ERROR = 'error';
    
    const WARNING = 'warning';
    
    const NOTICE = 'notice';
    
    const INFO = 'info';
    
    const DEBUG = 'debug';
    
    /**
     * Matches the correct log level to a route.
     * 
     * @param string $level
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function getPathFromLogLevel($level)
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
     * Matches the correct route for the Wind server to the log level.
     * 
     * @param string $route
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function getLogLevelFromRoute($route)
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
     * Get the requested path.
     * 
     * @return string
     */
    public function getRequestedPath()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            return $_SERVER['PATH_INFO'];
        }
        elseif (!empty($_SERVER['PHP_SELF']) && !empty($_SERVER['SCRIPT_NAME'])) {
            return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']));
        }
        else {
            return '';
        }
    }
    
    /**
     * Get the requested parameters.
     * 
     * @return array
     */
    public function getRequestParameters()
    {
        return $_POST;
    }
}