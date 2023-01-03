<?php

namespace app\classes;

class Create{

    public function create($table, $fields){
        $pdo = Connection::connect();

        $sql = "insert into {$table} (";
        $sql .= implode(', ', array_keys($fields)).") values(";
        $sql .= ":".implode(', :', array_keys($fields)).")";
        
        $register = $pdo->prepare($sql);
        $register->execute($fields);

        return $register->rowCount();
    }

}