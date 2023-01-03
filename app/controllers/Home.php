<?php

namespace app\controllers;

class Home{

    public function index(){
        $view = 'home';
        if(empty($_SESSION['LOGGED'])){
            $view = 'login';
        }
        return [
            'view' => $view
        ];

    }
}