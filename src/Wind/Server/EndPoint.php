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

use Wind\Server\RouterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;

class EndPoint implements LoggerAwareInterface
{
    /**
     * @var The logger to use to persist the logs.
     */
    protected $logger;
    
    /**
     * @var The router helper.
     */
    protected $router;
    
    public function __construct(LoggerInterface $logger = null, RouterInterface $router = null)
    {
        if (isset($logger)) {
            $this->setLogger($logger);
        }
        if (isset($router)) {
            $this->setRouter($router);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * Register the router.
     * 
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }
    
    /**
     * Run the server logic. Handle the request and respond.
     */
    public function run()
    {        
        if (!isset($this->router) || !isset($this->logger)) {
            throw new \RuntimeException("Tried to run Wind, but couldn't find a router and/or a logger instance.");
        }
        
        $route = $this->router->getRequestedPath();
        
        try {
            // Get the log level. This will trigger an error if the route is not matched to 
            // a log level. Catch it. We might want to add a front-end later.
            $level = $this->router->getLogLevelFromRoute($route);
            
            // Tell the caller we've got this.
            $this->router->respond('', 204);
            
            $params = $this->router->getPost();
            $this->logger->log($level, $params['message'], (array) json_decode($params['context']));
            
        } catch (\InvalidArgumentException $e) {
            // Reserve for a future web-interface ?
            // For now, return a 400 bad request.
            $this->router->respond('This method does not exist (yet ?)', 400);
        }
    }
}
