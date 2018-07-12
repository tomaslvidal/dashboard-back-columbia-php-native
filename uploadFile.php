<?php
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();

$jsondata["success"] = array();

$jsondata["base64"] = "";

$jsondata["error"] = array();

$jsondata["info"] = array();

$extFile = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

$uploadOk = 1;

$imageFileType = strtolower($extFile);

if(getimagesize($_FILES["image"]["tmp_name"]) !== false) {
    array_push($jsondata["info"], "File is an image");

    $uploadOk = 1;
}
else{
    array_push($jsondata["error"], "File is not an image.");

    $uploadOk = 0;
}

if($_FILES["image"]["size"] > 1700000){
    array_push($jsondata["error"], "Sorry, your file is too large.");

    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ){
    array_push($jsondata["error"], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");

    $uploadOk = 0;
}

if($uploadOk == 0){
    array_push($jsondata["error"], "Sorry, your file was not uploaded.");
}
else{
    $path = $_FILES["image"];

    $type = $extFile;

    $data = file_get_contents($_FILES["image"]["tmp_name"]);

    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $jsondata["success"] = true;

    $jsondata["base64"] = $base64;

    echo $jsondata["base64"];
}
?>
