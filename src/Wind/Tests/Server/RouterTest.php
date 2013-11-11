<?php

/**
 * @file
 * Wind server router unit tests.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Tests\Server;

use Wind\Server\Router;
use Psr\Log\LogLevel;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test matching the correct log level to a route.
     */
    public function testGetRouteFromLogLevel()
    {
        $router = new Router();
        $this->assertEquals(Router::EMERGENCY, $router->getRouteFromLogLevel(LogLevel::EMERGENCY), "Emergency route level does not match.");
        $this->assertEquals(Router::ALERT, $router->getRouteFromLogLevel(LogLevel::ALERT), "Alert route level does not match.");
        $this->assertEquals(Router::CRITICAL, $router->getRouteFromLogLevel(LogLevel::CRITICAL), "Critical route level does not match.");
        $this->assertEquals(Router::ERROR, $router->getRouteFromLogLevel(LogLevel::ERROR), "Error route level does not match.");
        $this->assertEquals(Router::WARNING, $router->getRouteFromLogLevel(LogLevel::WARNING), "Warning route level does not match.");
        $this->assertEquals(Router::NOTICE, $router->getRouteFromLogLevel(LogLevel::NOTICE), "Notice route level does not match.");
        $this->assertEquals(Router::INFO, $router->getRouteFromLogLevel(LogLevel::INFO), "Info route level does not match.");
        $this->assertEquals(Router::DEBUG, $router->getRouteFromLogLevel(LogLevel::DEBUG), "Debug route level does not match.");
    }

    /**
     * Test Exception when matching an invalid log level.
     */
    public function testInvalidArgumentExceptionWhenGettingRoute()
    {
        $router = new Router();
        $this->setExpectedException(
          'InvalidArgumentException', "Got a log level not specified by the PSR-3 standard. Log level received: __none."
        );
        $router->getRouteFromLogLevel('__none');
    }

    /**
     * Test matching the correct route to a log level.
     */
    public function testGetLogLevelFromRoute()
    {
        $router = new Router();
        $this->assertEquals(LogLevel::EMERGENCY, $router->getLogLevelFromRoute(Router::EMERGENCY), "Emergency route level does not match.");
        $this->assertEquals(LogLevel::ALERT, $router->getLogLevelFromRoute(Router::ALERT), "Alert route level does not match.");
        $this->assertEquals(LogLevel::CRITICAL, $router->getLogLevelFromRoute(Router::CRITICAL), "Critical route level does not match.");
        $this->assertEquals(LogLevel::ERROR, $router->getLogLevelFromRoute(Router::ERROR), "Error route level does not match.");
        $this->assertEquals(LogLevel::WARNING, $router->getLogLevelFromRoute(Router::WARNING), "Warning route level does not match.");
        $this->assertEquals(LogLevel::NOTICE, $router->getLogLevelFromRoute(Router::NOTICE), "Notice route level does not match.");
        $this->assertEquals(LogLevel::INFO, $router->getLogLevelFromRoute(Router::INFO), "Info route level does not match.");
        $this->assertEquals(LogLevel::DEBUG, $router->getLogLevelFromRoute(Router::DEBUG), "Debug route level does not match.");
    }

    /**
     * Test Exception when matching an invalid log level.
     */
    public function testInvalidArgumentExceptionWhenGettingLogLevel()
    {
        $router = new Router();
        $this->setExpectedException(
          'InvalidArgumentException', "Got a route that does not match any log level. Route received: __none."
        );
        $router->getLogLevelFromRoute('__none');
    }
}
