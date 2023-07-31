<?php

namespace app\Models;
use app\core\Application;
use app\core\DbModel;
use app\core\Model;

class User extends DbModel
{
    public int $id = 0;

    public string $name = "";
    public string $email = "";
    public string $password = "";
    public string $confirmPassword = "";

    public function tableName(): string
    {
        return "user";
    }
    public function attributesList(): array
    {
        $rules = $this->Rules();
        $attributes = [];
        foreach ($rules as $attribute => $value){
            $attributes[] = $attribute;
        }

        unset($attributes[array_key_last($attributes)]);
        return $attributes;
    }


    public function Rules() : array{
        return [
            "name" => [self::RULE_REQUIRED, [self::RULE_MIN_LENGHT, "min" => 4], [self::RULE_MAX_LENGHT, "max" => 8]],
            "email" =>
                [
                    self::RULE_REQUIRED,
                    self::RULE_Email,
                    [self::RULE_UNIQUE, "className" => self::class]
                ],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN_LENGHT, "min" => 8]],
            "confirmPassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function save() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function primaryKey(): string
    {
        return 'id';
    }
}
