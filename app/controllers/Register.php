<?php

namespace app\controllers;
use app\classes\Create;

class Register{

    public function index(){
        return [
            'view' => 'register'
        ];

    }

    public function create(){
       $validated = validate([
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required|email|unique',
        'phone' => 'required|formated',
        'birthDate' => 'required|formated',
        'password' => 'required|maxLen'
       ]);

       if(in_array(false, $validated)){
        setValues("register", $validated);
        setFlash('error', 'Preencha todo os campos corretamente');
        redirect('/register');
        return;
       }

       $validated['password'] = password_hash($validated['password'], PASSWORD_DEFAULT);
       $create = new Create;
       $created = $create->create('users', $validated);

       if(!$created){
        redirect('/register');
        return;
       }
       redirect('/');
    }
}