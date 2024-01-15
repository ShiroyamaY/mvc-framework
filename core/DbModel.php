<?php

namespace app\core;

use app\core\Application;
abstract class DbModel extends Model {
    abstract public static function tableName():string;
    abstract public function attributes():array;
    abstract public static function primaryKey():string;
    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $columns =implode(',', $attributes);
        $value = implode(',', array_map(fn($s)=>":$s",$attributes));
        $statement = self::prepare("INSERT INTO $tableName ($columns) VALUES("."$value".")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute",$this->{$attribute});
        }
        return $statement->execute();
    }
    public static function prepare($sql): bool|\PDOStatement
    {
        return \app\core\Application::$app->db->getPdo()->prepare($sql);
    }
    public static function findOne($where): mixed //[email => zura@example.com,firstname => zura]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode('AND ', array_map(fn($a) => "$a = :$a",$attributes));
        $statement = static::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value){
            $statement->bindValue(":$key",$value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

}