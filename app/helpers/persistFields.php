<?php

use Dotenv\Parser\Value;

function setValues(string $index, array|object $values){
    foreach ($values as $key => $value) {
        if($values[$key] === false){
            $values[$key] = "";
        }
    }
    if(is_array($values)){
        $values = (object)$values;
    }
    $_SESSION[$index] = (object)$values;
}

function getValues($index){
    $value = $_SESSION[$index];
    if(isset($_SESSION[$index])){
        unset($_SESSION[$index]);
    }
    return $value;
}