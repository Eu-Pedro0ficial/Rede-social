<?php
use app\classes\Fetch;
use app\classes\querybuilder\Model;

function validate(array $validated){
    $result = [];
    foreach ($validated as $field => $validate) {

        $result[$field] = (!str_contains($validate, "|")) ? singleValidation($validate, $field) : multipleValidation($validate, $field);

    }
    return $result;
}
function singleValidation($validate, $field){
    return $validate($field);
}
function multipleValidation($validate, $field){
    $result = [];
    $explodeValidate = explode('|',$validate);
    foreach ($explodeValidate as $value) {
        $result[$field] = $value($field);

        if($result[$field] === false || $result[$field] === null){
            break;
        }
    }
    return $result[$field];

}
function required($field){
    $require = strip_tags($_POST[$field]);
    if($require === ''){
        setFlash($field, 'Os campos precisam ser preenchidos!');
        return false;
    }
    return $require;
}
function unique($field){
    $fieldIsUnique = strip_tags($_POST[$field]);
    $search = new Fetch;
    $isUnique = $search->findBy('users', ['email' => $fieldIsUnique]);
    if($isUnique){
        setFlash($field, 'Esse email ja foi utilizado, escolha outro!');
        return false;
    }
    return $fieldIsUnique;
}
function formated($field){
    $formate = strip_tags($_POST[$field]);
    $pattern = '/[^0-9]+/';
    $replace = '';
    $formated = preg_replace($pattern, $replace, $formate);
    return $formated;
}
function maxLen($field){
    $fieldMaxLen = strip_tags($_POST[$field]);
    if(strlen($fieldMaxLen) > 12){
        setFlash($field, 'A senha não pode ter mais de 12 characteres');
        return false;
    }
    return $fieldMaxLen;
}
function email($field){
    $email = strip_tags($_POST[$field]);
    if(!$email){
        setFlash($field, 'Utilize um email valido por favor!');
        return false;
    }
    return $email;
}
function updateEmail($field){
    $email = strip_tags($_POST[$field]);
    $pattern = '/[^0-9]+/';

    $search = new Model;

    $search->read('users');
    $search->where(['email' => $email]);
    $search->orWhere(
        ['id' => preg_replace($pattern, '', logged()->id)],
        '!=',
        'and'
    );
    if(!$search->execute()){
        return $email;
    }
    return false;

}