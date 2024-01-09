<?php

namespace app\core;

use app\core\Application;
abstract class DbModel extends Model {
    abstract public static function tableName():string;
    abstract public function attributes():array;
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
    public function prepare($sql): bool|\PDOStatement
    {
        return \app\core\Application::$app->db->getPdo()->prepare($sql);
    }
}