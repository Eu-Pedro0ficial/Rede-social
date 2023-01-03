<?php

namespace app\classes;

class Fetch{

    public static function all($table){
        $pdo = Connection::connect();

        $sql = "select * from {$table}";
        $all = $pdo->prepare($sql);
        $all->execute();

        return $all->fetchAll();

    }

    public static function findBy(string $table,array $fields){
        $pdo = Connection::connect();

        $field = array_keys($fields);
        
        $sql = "select * from {$table} where {$field[0]} = :{$field[0]}";
        $findBy = $pdo->prepare($sql);
        $findBy->execute($fields);

        return $findBy->fetch();
    }

}