<?php

namespace app\core\Database;

use app\core\Application;
use app\core\Model;

abstract class DbModel extends Model
{
    abstract public function primaryKey(): string;
    abstract public function tableName() : string;
    abstract public function attributesList() : array;

    public function save(){
        $tableName =$this->tableName();
        $attributes = $this->attributesList();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        //imploding
        $implodedAttributes = implode(",",$attributes);
        $implodedParams = implode(",",$params);
        $SQL =
            "
                INSERT INTO $tableName 
                (".$implodedAttributes.")
                VALUES
                (".$implodedParams.")
            ";
        $statement = self::prepare($SQL);
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        return $statement->execute();
    }

    public function FindOne(array $where){
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $conditions = implode("AND", array_map(fn($attr)=> "$attr = :$attr", $attributes));
        $sqlStatement = "SELECT * FROM $tableName WHERE $conditions";
        $statement = self::prepare($sqlStatement);
        foreach ($where as $key => $value){
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }
}