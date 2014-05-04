<?php

/**
 * @file
 * Test against a real Wind server.
 *
 * Requires a running Wind server. This test expects a server to be started from
 * src/bin/server.sh.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Tests\bin;

use Wind\Client\Logger;
use Wind\Server\Router;
use Psr\Log\LogLevel;

class LiveTest extends \PHPUnit_Framework_TestCase 
{
    protected $server = 'http://localhost:6789';

    /**
     * Test against live Wind server.
     *
     * Requires src/bin/server.sh to be called prior.
     * Will empty the log file located at src/bin/log.log and make several
     * log requests, testing if they all got persisted correctly.
     */
    public function testLogging() 
    {
        $log_file = dirname(__FILE__) . '/../../../bin/log.log';

        $ch = curl_init($this->server);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // If we have an HTTP code, we know the server is running.
        if (!empty($http_code)) {
            // Empty the file.
            if (file_exists($log_file)) {
                $file = fopen($log_file, 'w');
                fwrite($file, '');
                fclose($file);
            }

            // Create a new Wind client.
            $logger = new Logger($this->server, new Router());

            // Check each log level.
            foreach (array(
                LogLevel::EMERGENCY => 'Emergency message',
                LogLevel::ALERT => 'Alert message',
                LogLevel::CRITICAL => 'Critical message',
                LogLevel::ERROR => 'Error message',
                LogLevel::WARNING => 'Warning message',
                LogLevel::NOTICE => 'Notice message',
                LogLevel::INFO => 'Info message',
                LogLevel::DEBUG => 'Debug message',
            ) as $level => $message) {
                $logger->log($level, $message);
                $this->assertContains($message, file_get_contents($log_file), $level . ' message got logged correctly.');
            }

            // Check context is set correctly.
            $logger->log(LogLevel::DEBUG, 'Try setting context', array('context' => 'Wind client'));
            $this->assertContains('{"context":"Wind client"}', file_get_contents($log_file), 'Context array was correctly passed.');
        } else {
            $this->markTestSkipped('The server is not running. Aborting live tests.');
        }
    }
}
