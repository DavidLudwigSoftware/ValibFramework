<?php

namespace Valib\View;

class Templates
{
    public static function load($view, $vars)
    {
        if (strtolower(env('template_engine')) == 'twig')

            return static::twig($view, $vars);
    }

    public static function twig($view, $vars)
    {
        return Twig::instance()->load($view . '.twig.php', $vars);
    }
}
