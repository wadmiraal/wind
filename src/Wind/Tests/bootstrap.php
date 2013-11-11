<?php

/**
 * @file
 * Register the autoloader for the unit tests.
 *
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$loader = require __DIR__ . '/../../../vendor/autoload.php';
$loader->add('Wind\\', __DIR__ . '/src/Wind');
