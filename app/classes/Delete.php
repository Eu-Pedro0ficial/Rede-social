<?php

namespace app\classes;
use app\database\Connection;

class Delete{
    public function delete($table, $fields){
        $pdo = Connection::connect();

        $field = array_keys($fields);

        $sql = "delete from {$table} where {$field[0]} = :{$field[0]}";
        $deleted = $pdo->prepare($sql);
        $deleted->execute($fields);

        return $deleted->rowCount();
    }
}
