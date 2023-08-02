<?php

namespace app\core\Exceptions;

class ForbiddenExeption extends \Exception
{
    protected $message = "Access Denied.";
    protected $code = 403;
}