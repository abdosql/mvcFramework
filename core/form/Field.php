<?php

namespace app\core\form;

use app\core\Model;

class Field extends Types
{
    //Fields Types
    private Model $Model;
    private string $Attribute;
    private string $Label;
    private string $Type;
    public function __construct(Model $Model, string $Attribute, string $Label)
    {
        $this->Model = $Model;
        $this->Attribute = $Attribute;
        $this->Label = $Label;
        $this->Type = self::TYPE_TEXT;
    }
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
                <label for="%s">%s:</label>
                <input type="%s" value="%s" class="form-control %s" id="%s" name="%s">
                <div class="invalid-feedback">
                %s
              </div>
            </div>
        ',
            $this->Attribute,
            $this->Label,
            $this->Type,
            $this->Model->{$this->Attribute},
            $this->Model->haseError($this->Attribute) ? 'is-invalid' : "",
            $this->Attribute,
            $this->Attribute,
            $errorMessages
        );
    }
    public function TypeText(){
        $this->Type = self::TYPE_TEXT;
        return $this;
    }

    public function TypePassword(){
        $this->Type = self::TYPE_PASSWORD;
        return $this;
    }

    public function TypeEmail(){
        $this->Type = self::TYPE_EMAIL;
        return $this;
    }

    public function TypeNumber(){
        $this->Type = self::TYPE_NUMBER;
        return $this;
    }

    public function TypeDate(){
        $this->Type = self::TYPE_DATE;
        return $this;
    }

    public function TypeTime(){
        $this->Type = self::TYPE_TIME;
        return $this;
    }

    public function TypeUrl(){
        $this->Type = self::TYPE_URL;
        return $this;
    }

    public function TypeSearch(){
        $this->Type = self::TYPE_SEARCH;
        return $this;
    }

    public function TypeCheckbox(){
        $this->Type = self::TYPE_CHECKBOX;
        return $this;
    }

    public function TypeRadio(){
        $this->Type = self::TYPE_RADIO;
        return $this;
    }

    public function TypeSelect(){
        $this->Type = self::TYPE_SELECT;
        return $this;
    }

    public function TypeFile(){
        $this->Type = self::TYPE_FILE;
        return $this;
    }

    public function TypeHidden(){
        $this->Type = self::TYPE_HIDDEN;
        return $this;
    }

    public function TypeImage(){
        $this->Type = self::TYPE_IMAGE;
        return $this;
    }

    public function TypeReset(){
        $this->Type = self::TYPE_RESET;
        return $this;
    }

    public function TypeSubmit(){
        $this->Type = self::TYPE_SUBMIT;
        return $this;
    }

    public function TypeButton(){
        $this->Type = self::TYPE_BUTTON;
        return $this;
    }

    public function TypeColor(){
        $this->Type = self::TYPE_COLOR;
        return $this;
    }

    public function TypeRange(){
        $this->Type = self::TYPE_RANGE;
        return $this;
    }

    public function TypeMonth(){
        $this->Type = self::TYPE_MONTH;
        return $this;
    }

    public function TypeWeek(){
        $this->Type = self::TYPE_WEEK;
        return $this;
    }

    public function TypeDatetimeLocal(){
        $this->Type = self::TYPE_DATETIME_LOCAL;
        return $this;
    }
}