<?php

namespace Valib\Traits;

use Valib\Http\Request;
use Valib\Validation\Validator;

trait Validator
{
    private $_validator;

    public function __construct()
    {
        $this->_validator = Validator::instance();
    }

    public function validate(Request $request)
    {
        return new ValidationResult();
    }

    public function error(string $name, string $error)
    {
        $this->_validator->addError($name, $error);
    }

    public function clearErrors()
    {

    }
}
