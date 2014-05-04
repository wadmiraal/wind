<?php

/**
 * @file
 * Sample script for launching Wind as a REST server.
 * 
 * This script launches a sample Wind server and stores all log request
 * to a file called log.log. This script requires the Monolog library.
 *
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Wind\Server\EndPoint;
use Wind\Server\Router;

try {
    $logger = new Logger('name');
    $logger->pushHandler(new StreamHandler(dirname(__FILE__) . '/log.log', Logger::DEBUG));
} catch (Exception $e) {
    die("This example script requires Monolog. Aborting.");
}

$wind = new Endpoint($logger, new Router());
$wind->run();
