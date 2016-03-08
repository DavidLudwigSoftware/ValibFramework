<?php

if (!function_exists('abort'))
{
    function abort(int $errorCode)
    {

        exit("$errorCode Error");
    }
}

if (!function_exists('config'))
{
    function config($file)
    {
        return require path('config') . "./$file.php";
    }
}

if (!function_exists('path'))
{
    function path($dir)
    {
        if ($dir == 'app')

            return DIR_ROOT . '/app';

        if ($dir == 'cache')

            return DIR_ROOT . '/storage/cache';

        if ($dir == 'config')

            return DIR_ROOT . '/config';

        if ($dir == 'storage')

            return DIR_ROOT . '/storage';

        if ($dir == 'resources')

            return DIR_ROOT . '/resources';
    }
}

if (!function_exists('dd'))
{
    function dd(...$args)
    {
        foreach ($args as $arg)
        {
            echo "<pre>";

            var_dump($arg);

            echo "</pre>";
        }
        exit();
    }
}

if (!function_exists('env'))
{
    function env($key)
    {
        return VALIB_CONFIG[strtoupper($key)];
    }
}

if (!function_exists('request'))
{
    function request()
    {
        return valib()->kernel()->request();
    }
}

if (!function_exists('redirect'))
{
    function redirect(string $url = Null)
    {
        return new Valib\Http\RedirectResponse($url);
    }
}

if (!function_exists('route'))
{
    function route(string $name, array $slugs = [])
    {
        $route = valib()->router()->route($name);

        return $route->generateUrl($slugs);
    }
}

if (!function_exists('valib'))
{
    function valib()
    {
        return \Valib\Core\Valib::instance();
    }
}

if (!function_exists('view'))
{
    function view(string $view, array $vars = [], $htmlOnly = False)
    {
        $html = Valib\View\Templates::load($view, $vars);

        if ($htmlOnly)

            return $html;

        $response = new Valib\Http\Response($html);

        return $response;
    }
}


if (!class_exists('Route', False))
{
    class Route extends Valib\Routing\Route {}
}
