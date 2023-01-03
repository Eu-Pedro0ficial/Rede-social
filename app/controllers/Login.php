<?php

namespace app\controllers;

use app\classes\Fetch;

class Login{

    public function store(){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $passwrod = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

        if(empty($email)| empty($passwrod)){
            setFlash("login", "Os campos não podem estar vazio");
            return redirect('/');
        }

        $user = Fetch::findBy('users', ['email' => $email]);

        if(!password_verify($passwrod, $user->password)){
            setFlash("login", "Email ou senha invalidos");
            return redirect('/');
        }

        $_SESSION['LOGGED'] = $user;
        redirect('/');
    }

    public function destroy(){
        unset($_SESSION['LOGGED']);
        redirect('/');
    }

}