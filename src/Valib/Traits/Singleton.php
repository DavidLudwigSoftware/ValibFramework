<?php

namespace Valib\Traits;

trait Singleton
{
    /**
     * Save the current instance of an object
     * @var Object instance
     */
    protected static $_instance;


    /**
     * Get the current instance of an object
     * @return Object instance
     */
    public static function instance()
    {
        if (static::$_instance == Null)

            static::$_instance = new static();

        return static::$_instance;
    }


    /**
     * Protected constructor to prevent 'new' instances
     */
    protected function __construct()
    {
    }


    /**
     * Private clone method to prevent cloning the instance
     * @return void
     */
    private function __clone()
    {

    }

    /**
     * Private unserialize method to prevent unserializing the instance
     * @return void
     */
    private function __wakeup()
    {

    }

}
