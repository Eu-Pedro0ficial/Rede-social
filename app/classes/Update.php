<?php 

namespace app\classes;
use app\database\Connection;

class Update{
    public function update($table, $fields, $where){
        $pdo = Connection::connect();

        $sql = "update {$table} set ";
        foreach ($fields as $key => $value) {
            $sql .= "{$key} = :{$key}, ";
        }
        $sql = rtrim($sql, ', ');
        $keyField = array_keys($where);
        $sql .= " where {$keyField[0]} = :{$keyField[0]}";

        $params = array_merge($fields, $where);

        $updated = $pdo->prepare($sql);
        $updated->execute($params);

        return $updated->rowCount();
    }
}