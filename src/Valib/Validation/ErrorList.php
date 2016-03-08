<?php

namespace Valib\Validation;

use Valib\Utility\ExtArray;

class ErrorList extends ExtArray
{
    public function first($key)
    {
        if ($this->has($key))

            return $this[$key][0];
    }

    public function field($key)
    {
        if ($this->has($key))

            return $this[$key];
    }

    public function all()
    {
        return $this->toArray();
    }

    public function set($key, $value)
    {
        if (!$this->has($key))

            parent::set($key, new ExtArray());

        $this[$key][] = $value;

        return $this;
    }
}
