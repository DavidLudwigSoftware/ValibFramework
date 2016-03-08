<?php

namespace Valib\Utility;

class ExtArray implements \ArrayAccess
{
    private $_data;

    public function __construct(array $data = [])
    {
        $this->_data = $data;
    }

    public function has($key)
    {
        return isset($this->_data[$key]);
    }

    public function get($key, $default = Null)
    {
        if ($this->has($key))

            return $this->_data;

        return $default;
    }

    public function set($key, $value)
    {
        if ($key === Null)

            $this->_data[] = $value;

        else

            $this->_data[$key] = $value;

        return $this;
    }

    public function remove($key)
    {
        if ($this->has($key))

            unset($this->_data[$key]);

        return $this;
    }

    public function count()
    {
        return count($this->_data);
    }

    public function toArray()
    {
        return $this->_data;
    }

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->remove($key);
    }


}
