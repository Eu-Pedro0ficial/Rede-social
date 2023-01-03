<?php

namespace app\classes\querybuilder;
use app\classes\Connection;

class Model{
    protected $query = '';
    public function read(string $table){
        $this->query = "select * from {$table}";
    }

    public function where(array $fields){
        $key = array_keys($fields);
        // dd($fields[$key[0]]);
        $this->query .= " where {$key[0]} = '{$fields[$key[0]]}'";
    }

    public function orWhere(array $fields, $operator = '=', $params = 'or'){
        $key = array_keys($fields);
        $this->query .= " {$params} {$key[0]} {$operator} '{$fields[$key[0]]}'";
        // return $this->query;
    }
    
    public function execute(){
        $pdo = Connection::connect();
        
        $execute = $pdo->prepare($this->query);
        $execute->execute();

        return $execute->fetch();
    }
}