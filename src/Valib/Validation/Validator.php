<?php

namespace Valib\Validation;

use Valib\Traits\Singleton;
use Valib\Utility\ExtArray;

class Validator
{
    use Singleton;

    private $_errors;

    protected function __construct()
    {
        $this->_errors = new ErrorList();
    }

    public function addError(string $field, string $error)
    {
        $this->_errors->set($field, $error);

        return $this;
    }

    public function errors()
    {
        return $this->_errors;
    }
}
