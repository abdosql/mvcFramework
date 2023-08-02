<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    public function __construct(Model $Model, string $Attribute, string $Label)
    {
        parent::__construct($Model, $Attribute, $Label);
        $this->Type = self::TYPE_TEXT;
    }
    protected string $Type;

    public function TypeText(): InputField
    {
        $this->Type = self::TYPE_TEXT;
        return $this;
    }

    public function TypePassword(): InputField
    {
        $this->Type = self::TYPE_PASSWORD;
        return $this;
    }

    public function TypeEmail(): InputField
    {
        $this->Type = self::TYPE_EMAIL;
        return $this;
    }

    public function TypeNumber(): InputField
    {
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

    public function TypeColor(): InputField
    {
        $this->Type = self::TYPE_COLOR;
        return $this;
    }

    public function TypeRange(): InputField
    {
        $this->Type = self::TYPE_RANGE;
        return $this;
    }

    public function TypeMonth(): InputField
    {
        $this->Type = self::TYPE_MONTH;
        return $this;
    }

    public function TypeWeek(): InputField
    {
        $this->Type = self::TYPE_WEEK;
        return $this;
    }

    public function TypeDatetimeLocal(): InputField
    {
        $this->Type = self::TYPE_DATETIME_LOCAL;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" value="%s" class="form-control %s" id="%s" name="%s">',
            $this->Type,
            $this->Model->{$this->Attribute},
            $this->Model->haseError($this->Attribute) ? 'is-invalid' : "",
            $this->Attribute,
            $this->Attribute,
        );
    }
}