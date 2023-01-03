<?php

require '../bootstrap.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$view = router();// dinamico
require '../app/views/master.php';

