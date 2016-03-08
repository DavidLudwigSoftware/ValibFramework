<?php

namespace Valib\View;

use Valib\Utility\Singleton;

class Twig
{
    use Singleton;

    private $_loader;
    private $_twig;

    protected function __construct()
    {
        $options = $this->options();

        $this->_loader = new \Twig_Loader_Filesystem(
            path('resources'). '/views'
        );

        $this->_twig = new \Twig_Environment($this->_loader, $options);

        $this->addHelperFunctions();
    }

    protected function addHelperFunctions()
    {
        $functions = array();

        $functions[] = new \Twig_SimpleFunction('route', function($name, $vars = []) {
            return route($name, $vars);
        });

        foreach ($functions as $function)

            $this->_twig->addFunction($function);
    }

    protected function options()
    {
        $options = array();

        if (env("template_cache"))

            $options['cache'] = path('cache') . '/twig';

        return $options;
    }

    public function load(string $view, array $vars = [])
    {
        return $this->_twig->render($view, $vars);
    }

}
