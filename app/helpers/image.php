<?php

function getExtension(string $name){
    return pathinfo($name, PATHINFO_EXTENSION);
}

function getFunctionCreateFrom(string $extension){
    return match($extension){
        'png' => ['imagecreatefrompng', 'imagepng'],
        'jpg','jpeg' => ['imagecreatefromjpeg', 'imagejpeg'],
        'gif' => ['imagecreatefromgif', 'imagegif'],
    };
}

function isFileToUpload($fieldName){
    if(!isset($_FILES[$fieldName], $_FILES[$fieldName]['name']) || $_FILES[$fieldName]['name'] == ''){
        return false;
    }
    return true;
}

function isImage($extension){
    $acceptedExtensions = ['jpeg', 'jpg', 'gif', 'png'];
    if(!in_array($extension, $acceptedExtensions)){
        $extensions = implode(",", $acceptedExtensions);
        throw new Exception("O arquivo não é aceito, aceitamos somente {$extensions}");
    }
}

function resize(int $width, int $height, int $newWidth, int $newHeight){
    $ratio = $width/$height;

    if($newWidth/$newHeight > $ratio){
        $newWidth = $newHeight*$ratio;
    }else {
        $newHeight = $newWidth/$ratio;
    }

    return [$newWidth, $newHeight];
}

function crop(int $width, int $height, int $newWidth, int $newHeight){
    $thumbWidth = $newWidth;
    $thumbHeight = $newHeight;

    $srcAspect = $width / $height;
    $dstAspect = $thumbWidth / $thumbHeight;

    ($srcAspect >= $dstAspect) ?
        $newWidth = $width / ($height / $thumbHeight) :
        $newHeight = $height / ($width / $thumbWidth);

    return [$newWidth, $newHeight, $thumbWidth, $thumbHeight];
}

function upload(int $newWidth, int $newHeight,string $folder, string $type = 'resize'){
    if(!isFileToUpload('path')){
        return '';
    }
    $extension = getExtension($_FILES['path']['name']);
    isImage($extension);
    
    [$width, $height] = getimagesize($_FILES['path']['tmp_name']);

    [$functionCreateFrom, $saveImage] = getFunctionCreateFrom($extension);

    $src = $functionCreateFrom($_FILES['path']['tmp_name']);
    
    if($type == 'resize'){
        [$newWidth, $newHeight] = resize($width, $height, $newWidth, $newHeight);
        $dst = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled(
        $dst,
        $src,
        0,
        0,
        0,
        0,
        $width,
        $height,
        $newWidth,
        $newHeight);
    }else{
        [$newWidth, $newHeight, $thumbWidth, $thumbHeight] = crop($width, $height, $newWidth, $newHeight);
        $dst = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled(
        $dst,
        $src,
        0 - ($newWidth - $thumbWidth) / 2,
        0 - ($newHeight - $thumbHeight) / 2,
        0,
        0,
        $width,
        $height,
        $width,
        $height
    );
    }

    $path = $folder.DIRECTORY_SEPARATOR.rand().".".$extension;

    $saveImage($dst, $path);

    return $path;
}