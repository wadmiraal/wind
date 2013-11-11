<?php

/**
 * @file
 * Wind server end-point unit tests.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Tests\Server;

use Wind\Server\EndPoint;
use Psr\Log\LogLevel;

class EndPointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test runtime exception. 
     *
     * Calling run() when no logger and/or no router is given must 
     * throw an exception.
     */
    public function testRuntimeExceptionNothingSet() 
    {
        $error_type = 'RuntimeException';
        $error_string = "Tried to run Wind, but couldn't find a router and/or a logger instance.";

        // Call run with no handler triggers an exception.
        $wind = new EndPoint();
        $this->setExpectedException(
          $error_type, $error_string
        );
        $wind->run();

        // Call run with only a logger triggers an exception.
        $logger = $this->mockLogger();
        $wind = new EndPoint();
        $wind->setLogger($logger);
        $this->setExpectedException(
          $error_type, $error_string
        );
        $wind->run();

        // Call run with only a router triggers an exception.
        $router = $this->mockRouter();
        $wind = new EndPoint();
        $wind->setRouter($router);
        $this->setExpectedException(
          $error_type, $error_string
        );
        $wind->run();

        // Call run with both does not trigger any error.
        $wind = new EndPoint($logger, $router);
        try {
            $wind->run();
            $this->pass("No exception was triggered.");
        } catch (Exception $e) {
            $this->fail("Calling run with a logger and a router triggered an exception.");
        }

    }

    /**
     * Create a mock logger.
     */
    protected function mockLogger()
    {
        $logger = $this->getMock('Logger');

        $logger->expects($this->once())
                ->method('log')
                ->with($this->equalTo(LogLevel::EMERGENCY, '', array()));

        return $logger;
    }

    /**
     * Create a mock router.
     */
    protected function mockRouter()
    {
        $router = $this->getMock('Router');

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
        
        return $router;
    }
}
