<?php

namespace Valib\Core;

use Valib\Http\Request;
use Valib\Http\Response;

use Valib\Route;

class Kernel
{
    /**
     * The active request
     * @var Valib\Http\Request
     */
    private $_request;

    /**
     * Handle a given request
     * @param  Valib\Http\Request $request
     * @return Valib\Http\Response
     */
    public function handle(Request $request)
    {
        $this->_request = $request;

        $route = $this->resolveRoute($request);

        if ($route)
        {
            $slugs = $route->mapSlugs($request->uri());

            $action = $this->resolveAction($route->action());

            $parameters = $this->resolveParameters($action, $slugs);

            $output = $this->callAction($action, $parameters);

            return $this->resolveResponse($output);
        }
        else

            abort(404);
    }

    /**
     * Resolve a route for the request
     * @param  Valib\Http\Request $request
     * @return Valib\Routing\Route
     */
    public function resolveRoute(Request $request)
    {
        $router = valib()->router();

        return $router->match($request);
    }

    /**
     * Resolve an action given by a route
     * @param  mixed $action
     * @return ReflectionMethod/ReflectionFunction
     */
    public function resolveAction($action)
    {
        if (gettype($action) == 'object')
        {
            return new \ReflectionFunction($action);
        }

        $parts = explode('@', $action);

        return new \ReflectionMethod($parts[0], $parts[1]);
    }

    /**
     * Resolve the parameters of an action
     * @param  mixed $action
     * @return array
     */
    public function resolveParameters($action, $slugs)
    {
        $parameters = [];

        $i = 0;

        foreach ($action->getParameters() as $param)
        {
            if ($param->getClass() === Null)

                $parameters[] = $i < count($slugs) ? $slugs[$i++] : Null;

            else
            {
                // $class = $param->getClass()->name;
                //
                // $parameters[] = new $class();
            }

        }

        return $parameters;
    }

    /**
     * Resolve a response from the given output
     * @param  mixed $output
     * @return void
     */
    public function resolveResponse($output)
    {
        if (gettype($output) == 'string')

            return new Response($output);

        return $output;
    }

    /**
     * Run the given action
     * @param  mixed $action
     * @param  array $parameters
     * @return mixed
     */
    public function callAction($action, $parameters)
    {
        if (is_a($action, 'ReflectionFunction'))

            return $action->invokeArgs($parameters);

        elseif (is_a($action, 'ReflectionMethod'))

            return $action->invokeArgs(new $action->class, $parameters);

    }

    public function request()
    {
        return $this->_request;
    }
}
