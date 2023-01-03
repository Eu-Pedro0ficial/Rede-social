<?php

function setFlash($index, $message){//cria a sessão
    if(!isset($_SESSION['flash'][$index])){//verifica se a sessão existe
        $_SESSION['flash'][$index] = $message; //se não existir cria
    }
}

function getFlash($index, $style = 'color:red', $class = "padrao"){//pegar a mensagem e mostrar
    if(isset($_SESSION['flash'][$index])){
        $flash = $_SESSION['flash'][$index]; //pegou a mensagem
        unset($_SESSION['flash'][$index]);// excluiu a sessão

        return "<span class='{$class}' style='{$style}'>$flash</span>"; // mostrou a mensagem que ele pegou antes de excluir a sessão.
    }
}