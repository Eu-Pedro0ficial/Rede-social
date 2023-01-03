<?php

use app\controllers\Home;

function exactUrl($url, $methodUrl ,$methodUri){
    return array_key_exists($url['path'], $methodUrl[$methodUri]) ?
        [$url['path'] => $methodUrl[$methodUri][$url['path']]] :
        [];
}

function router(){
    $methodUrl = require 'routes.php';

    $url = parse_url($_SERVER['REQUEST_URI']);// path => "url"
    $methodUri = $_SERVER['REQUEST_METHOD'];

    $exactUrl = exactUrl($url, $methodUrl, $methodUri);

    if(empty($exactUrl)){
        $exactUrl = array_filter(
            $methodUrl[$methodUri],
            function($value) use($url){
                $regex = str_replace('/', '\/', ltrim($value, '/'));
                return preg_match("/^$regex$/", ltrim($url['path'], '/'));
            },
            mode: ARRAY_FILTER_USE_KEY
        );
        
    }


    if(!empty($exactUrl)){
        $key = array_keys($exactUrl);

        [$class, $method] = explode('@',$exactUrl[$key[0]]);

        $teste = CONTROLLER_PATH.$class;
    
        $index = new $teste;
        return $index->$method();
    }

}