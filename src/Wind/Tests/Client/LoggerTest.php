<?php

/**
 * @file
 * Wind server client unit tests.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Tests\Client;

use Wind\Tests\WindBaseTest;
use Wind\Client\Logger;

class LoggerTest extends WindBaseTest
{
    /**
     * Test Exception when passing an invalid LogLevel.
     */
    public function testInvalidArgumentException()
    {
        $router = $this->mockRouter(false);
        $logger = new Logger('127.0.0.1:7777', $router);
        $this->setExpectedException(
          'InvalidArgumentException', "Got a log level not specified by the PSR-3 standard. Log level received: __none."
        );
        $logger->log('__none', 'message', array());
    }

}
