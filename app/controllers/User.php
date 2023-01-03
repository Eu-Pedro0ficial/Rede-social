<?php

namespace app\controllers;
use app\classes\Update;
use app\classes\Delete;

class User{
    public function profile(){
        $view = 'login';
        if(isset($_SESSION['LOGGED'])){
            $view = 'profile';
        }
        return [
            'view' => $view
        ];
    }

    public function update(){
        $view = 'login';
        if(isset($_SESSION['LOGGED'])){
            $view = 'update';
        }
        return [
            'view' => $view
        ];
    }

    public function updated(){
        $validated = validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|updateEmail',
            'phone' => 'required|formated',
            'birthDate' => 'required|formated',
        ]);
        if(in_array(false, $validated)){
            setValues("update", $validated);
            setFlash('updateUser', 'Não foi possivel alterar as informações do usuario, tente novamente mais tarde!');
            return redirect('/user/update');
        }
        $pattern = '/[^0-9]+/';
        if($_POST['id'] !== format($pattern, logged()->id)){
            setFlash('updateError', 'Erro ao atualizar as informações, tente novamente!');
            return redirect('/');    
        }
        $where = ['id' => $_POST['id']];

        $update = new Update;
        $updated = $update->update('users', $validated, $where);
        if(!$updated){
            setFlash('updateUser', 'Não foi possivel alterar as informações do usuario, tente novamente mais tarde!');
            return redirect('/profile');
        }
        setFlash('updateUser', 'Suas informações foram alteradas com sucesso!');
        return redirect('/profile');
    }

    public function delete(){
        $pattern = '/[^0-9]+/';

        $delete = new Delete;
        $deleted = $delete->delete('users', ['id' => format($pattern, logged()->id)]);
        
        if(!$deleted){
            setFlash('deleteUser', 'Não foi possivel deletar esse usuario. tente novamente mais tarde!');
            return redirect('/profile');
        }
        unset($_SESSION['LOGGED']);
        return redirect('/');
    }
}