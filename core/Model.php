<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_Email = 'email';
    public const RULE_MAX_LENGHT = 'maxLenght';
    public const RULE_MIN_LENGHT = 'minLenght';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            } else {
                return false;
            }
        }
    }
    abstract public function Rules();
    public function Validate(): bool
    {
        foreach ($this->Rules() as $attribute => $rules) {
            $attributeValue = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                //checking if Attribute value exists
                if ($ruleName === self::RULE_REQUIRED && !isset($attributeValue)) {
                    $this->newRuleError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_Email && !filter_var($attributeValue, FILTER_VALIDATE_EMAIL)) {
                    $this->newRuleError($attribute, self::RULE_Email);
                }
                if ($ruleName === self::RULE_MAX_LENGHT && strlen($attributeValue) > $rule["max"]) {
                    $this->newRuleError($attribute, self::RULE_MAX_LENGHT, $rule);
                }
                if ($ruleName === self::RULE_MIN_LENGHT && strlen($attributeValue) < $rule["min"]) {
                    $this->newRuleError($attribute, self::RULE_MIN_LENGHT, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $attributeValue != $this->{$rule["match"]}) {
                    $this->newRuleError($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE){
                    $className = $rule["className"];
                    $uniqueAttr = $rule["attribute"] ?? $attribute;
                    $tableName = $className::tableName();
                    $SQL = "SELECT * FROM $tableName WHERE $attribute = :attr";
                    $statement = Application::$app->db->pdo->prepare($SQL);
                    $statement->bindValue(":attr", $attributeValue);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record){
                        $this->newRuleError($attribute, self::RULE_UNIQUE, ["field" => $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }
    public function addError(string $attributeName, $message){
        $this->errors[$attributeName][] = $message;
    }
    private function newRuleError(string $attributeName, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? "";
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attributeName][] = $message;
    }
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_Email => "This field must be a valid email adress",
            self::RULE_MAX_LENGHT => "Max length of this field must be {max}",
            self::RULE_MIN_LENGHT => "Min length of this field must be {min}",
            self::RULE_MATCH => "This field must be the same as {match}",
            self::RULE_UNIQUE => "Record with this {field} already exits",
        ];
    }
    public function haseError($attribute){
        return $this->errors[$attribute] ?? false;
    }
    public function getErrorMessages($attribute){
        return $this->errors[$attribute];
    }
}