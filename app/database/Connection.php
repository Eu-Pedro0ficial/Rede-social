<?php

namespace app\database;
use PDO;

class Connection{
    public static function connect(){
        $pdo = new PDO(
            "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']}",
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD']
        );
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $pdo;
    }
}