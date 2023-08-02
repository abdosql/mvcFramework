<?php

namespace app\core\form;

class TextareaField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('
            <textarea name="%s" class="form-control %s" placeholder="Leave a comment here" id="%s"></textarea>',
            $this->Model->{$this->Attribute},
            $this->Model->haseError($this->Attribute) ? 'is-invalid' : "",
            $this->Attribute
            );
    }
}