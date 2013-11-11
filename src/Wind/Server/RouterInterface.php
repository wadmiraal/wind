<?php

/**
 * @file
 * Wind server router interface.
 * 
 * Defines the interface expected by the Wind server endpoint.
 * 
 * (c) Wouter Admiraal <wad@wadmiraal.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wind\Server;

interface RouterInerface
{
    /**
     * Matches the correct PSR-3 log level to a route.
     * 
     * @param string $level
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getRouteFromLogLevel($level);
    
    /**
     * Matches the correct route for the Wind server to the PSR-3 log level.
     * 
     * @param string $route
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getLogLevelFromRoute($route);
    
    /**
     * Get the requested path.
     * 
     * @return string
     */
    public function getRequestedPath();
    
    /**
     * Respond to the request.
     * 
     * @param string $body
     * @param int $http_code = 302
     */
    public function respond($body, $http_code = 302);
    
    /**
     * Get the requested POST parameters.
     * 
     * @return array
     */
    public function getPost();
}