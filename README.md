Wind - Fast logging for PHP
===========================

[![Build Status](https://travis-ci.org/wadmiraal/wind.svg?branch=master)](https://travis-ci.org/wadmiraal/wind) [![Coverage Status](https://coveralls.io/repos/wadmiraal/wind/badge.png?branch=master)](https://coveralls.io/r/wadmiraal/wind?branch=master)

Wind is a lightweight and fast logging server for PHP.

Goal
----

Logging can slow down a PHP application. PHP runs everything in the same process, and logging operations can be heavy, both in memory and IO. Some solutions exist to split the workload and let another application handle the logging, but most are heavy and require complicated setup.

Wind exposes a light REST server to which the main PHP application can post log requests. This will trigger a *new* PHP process for the actual logging, leaving the main application to concentrate on its main tasks.

Wind responds with a `HTTP/1.0 204 No Response`, immediately terminating the request for the calling application. Wind then proceeds to forward the log request to the chosen library, which will persist the log.

Wind does not provide any logging functionality as-is. It is meant to be used with a PSR-3 compatible logging library (like [Monolog](https://github.com/Seldaek/monolog)).

Installation
------------

The easiest way is through [Composer](https://getcomposer.org). Create a `composer.json` file, or copy the `composer.json.dist` file that comes with Wind:

````json
{
    "require": {
        "wadmiraal/wind": "dev-master"
    }
}
````

Next, call `composer install`, or `composer update` if you already had installed packages before.

Usage
-----

You'll find an example script in `vendor/bin/server.php`. 

*Note: what follows is only valid if installed through Composer.*

`vendor/bin/server.sh` launches PHP's built in server, which is not meant to be used in production environments; it only serves as an example. The script listens to `localhost:6789` and routes requests to `vendor/bin/server.php`. You can use it with the following commands:

````bash
cd vendor/bin
chmod +x server.sh
./server.sh
````

This will launch a Wind server, using [Monolog](https://github.com/Seldaek/monolog) (if it fails, make sure to update your `composer.json` to include `"monolog/monolog": "1.9.1"`).

You can now post log requests, using the `Wind\Client\Logger` class:

````php

use Psr\Log\LogLevel;
use Wind\Client\Logger;
use Wind\Server\Router;

$logger = new Logger('http://localhost:6789', new Router());

$logger->log(LogLevel::NOTICE, 'Log this message for me', array('in_context' => 'of something'));

````

Checkout `vendor/bin/server.php` for a concrete example of using Wind server-side with Monolog. There are many ways to set this up, but one good idea would be to set up an Apache or NginX virtual host, specifically for Wind. This could even be running on a different server, to reduce the workload on your application server even more (make sure to protect it from public writes, in this case).

Here's a basic example, using Monolog:

````php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Wind\Server\EndPoint;
use Wind\Server\Router;

$logger = new Logger('name');
$logger->pushHandler(new StreamHandler('./log.log', Logger::DEBUG));
$wind = new EndPoint($logger, new Router());
$wind->run();

````
