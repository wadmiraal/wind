<?php

/**
 * @file
 * Wind server end-point.
 * 
 * The Wind server endpoint receives the requests and routes them to the
 * logger used.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Server;

use Wind\Server\Router;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;

class Server implements LoggerAwareInterface
{
    /**
     * @var The logger to use to persist the logs.
     */
    protected $logger;
    
    /**
     * @var The router helper.
     */
    protected $router;
    
    /**
     * @inheritDoc
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->router = new Router();
    }
    
    /**
     * Run the server logic. Handle the request and respond.
     */
    public function run()
    {        
        $route = $this->router->getRequestedPath();
        
        switch ($route) {
            case Router::EMERGENCY:
            case Router::ALERT:
            case Router::CRITICAL:
            case Router::ERROR:
            case Router::WARNING:
            case Router::NOTICE:
            case Router::INFO:
            case Router::DEBUG:
                // Tell the caller we've got this.
                $this->router->respondWith204();
                
                // Handle the request and log.
                $params = $this->router->getPost();
                $level = Router::getLogLevelFromRoute($route);
                $this->logger->log($level, $params['message'], $params['context']);
                break;
        }
    }
}
