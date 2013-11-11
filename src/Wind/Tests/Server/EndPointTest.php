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

use Wind\Tests\WindBaseTest;
use Wind\Server\EndPoint;
use Psr\Log\LogLevel;

class EndPointTest extends WindBaseTest
{
    protected $runtime_error_type = 'RuntimeException';
    protected $runtime_error_msg = "Tried to run Wind, but couldn't find a router and/or a logger instance.";

    /**
     * Test runtime exception. 
     *
     * Calling run() when no logger and no router is given must 
     * throw an exception.
     */
    public function testRuntimeExceptionNothingSet() 
    {
        // Call run with no handler triggers an exception.
        $wind = new EndPoint();
        $this->setExpectedException(
          $this->runtime_error_type, $this->runtime_error_msg
        );
        $wind->run();
    }

    /**
     * Test runtime exception. 
     *
     * Calling run() when only a logger and no router is given must 
     * throw an exception.
     */
    public function testRuntimeExceptionLoggerSet()
    {
        // Call run with only a logger triggers an exception.
        $logger = $this->mockLogger(false);
        $wind = new EndPoint();
        $wind->setLogger($logger);
        $this->setExpectedException(
          $this->runtime_error_type, $this->runtime_error_msg
        );
        $wind->run();
    }

    /**
     * Test runtime exception. 
     *
     * Calling run() when only a router and no logger is given must 
     * throw an exception.
     */
    public function testRuntimeExceptionRouterSet()
    {
        // Call run with only a router triggers an exception.
        $router = $this->mockRouter(false);
        $wind = new EndPoint();
        $wind->setRouter($router);
        $this->setExpectedException(
          $this->runtime_error_type, $this->runtime_error_msg
        );
        $wind->run();
    }

    /**
     * Test runtime exception. 
     *
     * Calling run() when both a logger and a router are given must 
     * not throw any exception.
     */
    public function testNoRuntimeExceptionWhenBothSet()
    {
        // Call run with both does not trigger any error.
        $logger = $this->mockLogger();
        $router = $this->mockRouter();
        $wind = new EndPoint($logger, $router);
        try {
            $wind->run();
            $this->assertTrue(true, "No exception was triggered.");
        } catch (Exception $e) {
            $this->assertTrue(false, "Calling run with a logger and a router triggered an exception.");
        }
    }
}
