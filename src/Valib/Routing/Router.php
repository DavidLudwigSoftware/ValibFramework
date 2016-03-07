<?php

namespace Valib\Routing;

use Valib\Http\Request;

class Router
{
    /**
     * A list of routes
     * @var array
     */
    private $_routes = [];


    public function __construct()
    {
    }

    /**
     * Load the routes from the routes file
     * @return void
     */
    public function loadRoutes()
    {
        require path('app') . '/Http/routes.php';
    }

    /**
     * Find a route from the given Uri
     * @param  string $uri
     * @return Valib\Routing\Route
     */
    public function match(Request $request)
    {
        foreach ($this->_routes as $route)
        {
            if ($route->matches($request->method(), $request->uri()))

                return $route;
        }

        return Null;
    }

    /**
     * Add a route to the router
     * @param  Valib\Routing\Route $route
     * @return this
     */
    public function addRoute(Route $route)
    {
        $this->_routes[] = $route;

        return $this;
    }
}
