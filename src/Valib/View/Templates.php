<?php

namespace Valib\View;

use Valib\Utility\ExtArray;
use Valib\Validation\Validator;

class Templates
{
    public static function load($view, $vars)
    {
        $vars = static::setupVars($vars);

        if (strtolower(env('template_engine')) == 'twig')

            return static::twig($view, $vars);
    }

    public static function setupVars($vars)
    {
        $validator = Validator::instance();
        $list = new ExtArray();

        $list['errors'] = $validator->errors();

        return $list->toArray();
    }

    public static function twig($view, $vars)
    {
        return Twig::instance()->load($view . '.twig.php', $vars);
    }
}
