<?php

namespace app\controllers;
use app\classes\Create;
use app\classes\querybuilder\Model;
use app\classes\Delete;
use app\classes\Update;


class Posts{
   
    public function create(){
        
        $path = upload(640, 480, 'assets/img');
        $content = strip_tags($_POST['content']);
        $auth = logged();
        $regex = '/[^1-9]/';
        $id = preg_replace($regex, "", $auth->id);

        if($path === "" && $content === ""){
            setFlash('posts', 'Para publicar algo, precisa existir algum conteudo na publicação!');
            return;
        }
        $create = new Create;
        $created = $create->create('posts', ['idUsers' => $id, 'path' => $path, 'content' => $content,]);
        
        if(!$created){
            setFlash('posts', 'Não foi possivel criar o post, tente novamente mais tarde!');
        }
        redirect('/');
    }
    
    public function delete(){
        $pattern = '/[^0-9]+/';
        $idPost = format($pattern, parse_url($_SERVER['REQUEST_URI'])['path']);
        $idUser = format($pattern, logged()->id);

        $model = new Model;

        $model->read('posts');
        $model->where(['id' => $idPost]);
        $model->orWhere(['idUsers' => $idUser], '=', 'and');
        $found = $model->execute();

        if(!$found){
            setFlash('posts', 'Não foi possivel deletar esse post, tente novamente!');
            return redirect('/');
        }

        $delete = new Delete;
        $deleted = $delete->delete('posts', ['id' => $idPost]);

        if(!$deleted){
            setFlash('posts', 'Não foi possivel deletar esse post, tente novamente!');
            return redirect('/');
        }
        @unlink($found->path);
        setFlash('posts', 'Post deletado com sucesso!');
        return redirect('/');

    }

    public function update(){
        $pattern = '/[^0-9]+/';
        $idPost = format($pattern, parse_url($_SERVER['REQUEST_URI'])['path']);
        $idUser = format($pattern, logged()->id);

        $model = new Model;

        $model->read('posts');
        $model->where(['id' => $idPost]);
        $model->orWhere(['idUsers' => $idUser], '=', 'and');
        $found = $model->execute();
        
        $_SESSION['POST'] = $found;

        return [
            'view' => 'updatePost',
        ];
    }

    public function updated(){
        $pattern = '/[^0-9]+/';
        $idPost = format($pattern, $_SESSION['POST']->id);
        $path = upload(640, 480, 'assets/img');
        $content = strip_tags($_POST['content']);

        if($_POST['id'] !== $idPost){
            setFlash('posts', 'Não foi possivel modificar essa postagem, tente novamente mais tarde!');
            return redirect('/');
        }

        if($path === "" && $content === ""){
            setFlash('posts', 'Para publicar algo, precisa existir algum conteudo na publicação!');
            return redirect('/');
        }
        $update = new Update;
        
        $updated = $update->update('posts', ['path' => $path, 'content' => $content], ['id' => $idPost]);
        @unlink($_SESSION['POST']->path);

        if(!$updated){
            setFlash('posts', 'Não foi possivel modificar a postagem, tente novamente mais tarde!');
            return redirect('/');
        }
        unset($_SESSION['POST']);
        setFlash('posts', 'Postagem modificada com sucesso!');
        return redirect('/');
    }

}