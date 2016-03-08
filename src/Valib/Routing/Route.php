<?php

namespace Valib\Routing;

class Route
{
    /**
     * Store group middleware
     * @var [type]
     */
    protected static $_groupMiddleware = [];
    /**
     * The action to perform
     * @var mixed
     */
    private $_action;

    /**
     * The Http method
     * @var [type]
     */
    private $_method;

    /**
     * Middleware for the route
     * @var array
     */
    private $_middleware;

    /**
     * Name of the route
     * @var string
     */
    private $_name;

    /**
     * The Uri to match
     * @var string
     */
    private $_uri;

    /**
     * Create a route group and set group middleware
     * @param array $middleware an array of middleware
     * @param       $builder    a function containing route statements
     * @return void
     */
    public static function group(array $middleware, \Closure $closure)
    {
        // Set the group middleware
        static::$_groupMiddleware = $middleware;

        // Build the routes
        $closure();

        // Clear the group middleware
        static::$_groupMiddleware = [];
    }

    /**
     * Add a route for the GET Http method
     * @param  string $uri        The Uri of the route
     * @param  array  $middleware An array of middleware
     * @param  mixed  $action     A function, or array containing a controller
     * @return void
     */
    public static function get(string $uri, array $middleware, $action)
    {
        // Join the middleware with the group's middleware
        $middleware = array_merge(static::$_groupMiddleware, $middleware);

        // Create the route
        $route = new static('GET', $uri, $middleware, $action);

        // Add the route to the router
        valib()->router()->addRoute($route);
    }

    /**
     * Add a route for the POST Http method
     * @param  string $uri        The Uri of the route
     * @param  array  $middleware An array of middleware
     * @param  mixed  $action     A function, or array containing a controller
     * @return void
     */
    public static function post(string $uri, array $middleware, $action)
    {
        // Join the middleware with the group's middleware
        $middleware = array_merge(static::$_groupMiddleware, $middleware);

        // Create the route
        $route = new static('POST', $uri, $middleware, $action);

        // Add the route to the router
        valib()->router()->addRoute($route);
    }

    /**
     * Creat a new route
     * @param string $method     The Http method
     * @param string $uri        The Uri of the route
     * @param array  $middleware An array of middleware
     * @param mixed  $action     A function, or array containing a controller
     */
    public function __construct(string $method, string $uri,
                                array $middleware, $action)
    {
        // Set route information
        $this->_method     = $method;
        $this->_uri        = env('base_uri') . $uri;
        $this->_middleware = $middleware;
        $this->_action     = $action;

        // Resolve the action if the action is an array
        if (gettype($action) == 'array')

            $this->resolveAction();
    }

    /**
     * [resolveAction description]
     * @param  array $action An array of action information
     * @return void
     */
    protected function resolveAction()
    {
        $controller = $this->_action['uses'];

        if (isset($this->_action['as']))

            $this->_name = $this->_action['as'];

        $this->_action = $controller;
    }

    /**
     * Checks to see if the route's Uri matches the given Uri
     * @param  string $uri The Uri to compare
     * @return bool
     */
    public function matches(string $method, string $uri)
    {
        if ($method != $this->_method)

            return False;

        if ($uri == $this->_uri)

            return True;

        $uriSlugs = preg_split('/\//', $uri, -1, PREG_SPLIT_NO_EMPTY);
        $slugs = preg_split('/\//', $this->_uri, -1, PREG_SPLIT_NO_EMPTY);

        if (count($uriSlugs) == count($slugs))
        {
            for ($i = 0; $i < count($slugs); $i++)
            {
                $slug = $slugs[$i];
                $cSlug = $uriSlugs[$i];

                if ($slug != $cSlug && $slug != '{}')

                    return False;
            }

            return True;
        }
        return False;
    }

    /**
     * Map the slugs from the Uri
     * @return array
     */
    public function mapSlugs(string $uri)
    {
        $values = array();

        $uriSlugs = preg_split('/\//', $uri, -1, PREG_SPLIT_NO_EMPTY);
        $slugs = preg_split('/\//', $this->_uri, -1, PREG_SPLIT_NO_EMPTY);

        for ($i = 0; $i < count($slugs); $i++)
        {
            $slug = $slugs[$i];
            $cSlug = $uriSlugs[$i];

            if ($slug == '{}')

                $values[] = $cSlug;
        }

        return $values;
    }

    public function generateUrl($slugs)
    {
        $parts = preg_split('/\//', $this->_uri);

        $url = "";

        for ($i = 1; $i < count($parts); $i++)

            if ($parts[$i] == '{}')

                $url .= '/' . urlencode(array_shift($slugs));

            else

                $url .= '/' . $parts[$i];

        return $url;
    }

    /**
     * Get the action of this route
     * @return mixed Can be a function, or a controller string
     */
    public function action()
    {
        return $this->_action;
    }

    /**
     * Get the method of this route
     * @return string
     */
    public function method()
    {
        return $this->_method;
    }

    /**
     * Get the middleware for this route
     * @return array Contains strings of middleware
     */
    public function middleware()
    {
        return $this->_middleware;
    }

    /**
     * Get the name of this route
     * @return string Null if a name isn't set
     */
    public function name()
    {
        return $this->_name;
    }

    /**
     * Get the Uri of this route
     * @return string
     */
    public function uri()
    {
        return $this->_uri;
    }
}
