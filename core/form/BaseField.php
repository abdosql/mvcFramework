<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField extends Types
{
    //Fields Types
    protected Model $Model;
    protected string $Attribute;
    protected string $Label;
    public function __construct(Model $Model, string $Attribute, string $Label)
    {
        $this->Model = $Model;
        $this->Attribute = $Attribute;
        $this->Label = $Label;
    }
    abstract public function renderInput(): string;
    public function __toString()
    {
        $errorMessages = "";
        if ($this->Model->haseError($this->Attribute)) {
            foreach ($this->Model->getErrorMessages($this->Attribute) as $message) {
                $errorMessages .= "$message <br>";
            }
        }
        return sprintf('
            <div class="form-group mb-3 has-alidation">
                <label class="mb-2" for="%s">%s:</label>
                %s
                <div class="invalid-feedback">
                %s
              </div>
            </div>
        ',
            $this->Attribute,
            $this->Label,
            $this->renderInput(),
            $errorMessages
        );
    }
}