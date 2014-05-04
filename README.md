Wind - Fast logging for PHP
===========================

[![Build Status](https://travis-ci.org/wadmiraal/wind.svg?branch=master)](https://travis-ci.org/wadmiraal/wind) [![Coverage Status](https://coveralls.io/repos/wadmiraal/wind/badge.png)](https://coveralls.io/r/wadmiraal/wind)

Wind is a lightweight and fast logging server for PHP.

Goal
----

Logging can slow down an application. PHP runs everything in the same process, and logging operations can be heavy, both in memory and IO.

Wind exposes a light REST server to which the main PHP application can post log requests. This will trigger a *new* PHP process for the actual logging, leaving the main application to concentrate on its main tasks.

Wind responds with a `HTTP/1.0 204 No Response`, immediately terminating the request for the calling application. Wind then proceeds to forward the log request to the chosen library, which will persist the log.

Wind does not provide any logging functionality as-is. It is meant to be used with a PSR-3 compatible logging library (like [Monolog](https://github.com/Seldaek/monolog)).

Usage
-----

You'll find an example script in `src/bin/server.sh`. It launches PHP's built in server, which is not meant to be used in production environments. It serves as an example. It launches `server.php`. You can use it with the following commands:

````bash
chmod +x src/bin/server.sh
./src/bin/server.sh
````

This will launch a Wind server at `localhost:6789`, using [Monolog](https://github.com/Seldaek/monolog) (if it fails, make sure to update your `composer.json` to include `"monolog/monolog": "1.9.1"`).

You can now post log requests, using the `Wind\Client\Logger` class:

````php

use Psr\Log\LogLevel;
use Wind\Client\Logger;
use Wind\Server\Router;

$logger = new Logger('http://localhost:6789', new Router());

$logger->log(LogLevel::NOTICE, 'Log this message for me', array('in_context' => 'of something'));

````

Checkout `src/bin/server.php` for a concrete example of using Wind server-side with Monolog.
