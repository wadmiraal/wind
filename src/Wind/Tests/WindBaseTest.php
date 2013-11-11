<?php

/**
 * @file
 * Defines the base unit test class for Wind.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Tests;

use Psr\Log\LogLevel;

class WindBaseTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * Create a mock logger.
     *
     * @param bool $methods = true
     *        Mock the method implementations or not.
     * @return Psr\Log\LoggerInterface
     */
    protected function mockLogger($methods = true)
    {
        $logger = $this->getMock('Psr\Log\LoggerInterface');

        if ($methods) {
            $logger->expects($this->once())
                    ->method('log')
                    ->with($this->equalTo(LogLevel::EMERGENCY), $this->equalTo(''), $this->equalTo(array()));
        }

        return $logger;
    }

    /**
     * Create a mock router.
     *
     * @param bool $methods = true
     *        Mock the method implementations or not.
     * @return Wind\Server\RouterInterface
     */
    protected function mockRouter($methods = true)
    {
        $router = $this->getMock('Wind\Server\RouterInterface');

        if ($methods) {
            $router->expects($this->once())
                    ->method('getRequestedPath')
                    ->will($this->returnValue('emergency'));

            $router->expects($this->once())
                    ->method('getLogLevelFromRoute')
                    ->with($this->equalTo('emergency'))
                    ->will($this->returnValue(LogLevel::EMERGENCY));

            $router->expects($this->once())
                    ->method('respond')
                    ->with($this->equalTo(''), $this->equalTo(204));

            $router->expects($this->once())
                    ->method('getPost')
                    ->will($this->returnValue(array('message' => '', 'context' => '[]')));
        }

        return $router;
    }

}
