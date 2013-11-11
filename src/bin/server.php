<?php

/**
 * @file
 */

// Fetch the Composer autoload logic.
require '../../../../vendor/autoload.php';

try {
    // todo
    $logger = new Monolog();
} catch (Exception $e) {
    die("This example script requires Monolog. Aborting.");
}

$router = new Wind\Server\Router();
$wind = new Wind\Server\EndPoint($logger, $router);
$wind->run();