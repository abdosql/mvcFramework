<?php

namespace app\core\form;

class Form
{
    public static function Begin($action, $method): Form
    {
        echo sprintf("<form action='%s' method='%s'>", $action, $method);
        return new Form();
    }
    public static function End(){
        echo "<form/>";
    }
    public function InputField($model, $attribute, $label): InputField
    {
        return new InputField($model, $attribute, $label);
    }
    public function TextAreaField($model, $attribute, $label): TextareaField
    {
        return new TextareaField($model, $attribute, $label);
    }
}
