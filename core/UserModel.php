<?php

namespace app\core;

use app\core\Database\DbModel;
use Exception;

abstract class UserModel extends DbModel
{
    /**
     * @throws Exception
     */
    public function _get(string $property){
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new Exception("Property '{$property}' does not exist.");
        }
    }
}