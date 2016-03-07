<?php

namespace Valib\Core;

use Valib\Utility\Singleton;

use Valib\Http\Kernel;
use Valib\Http\Request;
use Valib\Http\Response;

use Valib\Routing\Router;

class Valib
{
    use Singleton;
    /**
     * Store the instance of the kernel
     * @var Valib\Http\Kernel
     */
    private $_kernel;

    /**
     * Store the instance of the router
     * @var Valib\Routing\Router
     */
    private $_router;

    /**
     * Create the Valib application
     * @param array $config
     */
    protected function __construct()
    {
        // Define the constants
        define('VALIB_CONFIG', $this->loadConfig());

        // Load in the helper functions
        require_once (__DIR__ . '/helpers.php');
    }

    /**
     * Execute the application
     * @param  Valib\Http\Request $request
     * @return Valib\Http\Response
     */
    public function exec(Request $request = Null)
    {
        // Initialize the Kernel
        $this->_kernel = new $this->_kernel();

        // Initialize the router
        $this->_router = new Router();

        // Load the routes
        $this->_router->loadRoutes();

        // Handle the request and get the response
        $response = $this->_kernel->handle($request);

        // Return the response
        return $response;
    }

    /**
     * Cleanup after execution
     * @return void
     */
    public function clean()
    {

    }

    /**
     * Load the configuration from 'config.ini'
     * @return [type] [description]
     */
    public function loadConfig()
    {
        return parse_ini_file(
            DIR_ROOT . '/config.ini', False
        );
    }

    /**
     * Get the kernel for the application
     * @return Valib\Http\Kernel
     */
    public function kernel()
    {
        return $this->_kernel;
    }

    /**
     * Get the router for the application
     * @return Valib\Routing\Router
     */
    public function router()
    {
        return $this->_router;
    }

    /**
     * Set the kernel for the application
     * @param Valib\Http\Kernel::class $kernel
     * @return self
     */
    public function setKernel($kernel)
    {
        $this->_kernel = $kernel;

        return $this;
    }
}
