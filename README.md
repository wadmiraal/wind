wind
====

Wind is a lightweight and fast logging server for PHP. 

Currently it's more a proof of concept.

Goal
----

Logging can slow down an application. PHP runs everything in the same process. 

Wind exposes a light REST server to which the main PHP application can post log requests. This will trigger a *new* PHP process for the actual logging,
leaving the main application to concentrate on its main tasks.

Wind does not provide any logging functionality as-is. It is meant to be used with a PSR-3 compatible logging library (like Monolog).

Usage
-----

Coming soon...