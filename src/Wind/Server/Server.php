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
    
    
}