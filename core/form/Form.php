<?php

namespace app\core\form;

class Form
{
    public static function Begin($action, $method){
        echo sprintf("<form action='%s' method='%s'>", $action, $method);
        return new Form();
    }
    public static function End(){
        echo "<form/>";
    }
    public function field($model, $attribute, $label){
        return new Field($model, $attribute, $label);
    }
}
