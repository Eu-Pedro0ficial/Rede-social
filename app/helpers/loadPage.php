<?php

function load($page){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        die();
    }
    require "../app/views/{$page}.php";
}