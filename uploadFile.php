<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/generalPanel.php");

$jsondata = array();
$jsondata["success"] = array();
$jsondata["base64"] = "";
$jsondata["error"] = array();
$jsondata["info"] = array();

$dirImages = $dir."uploads/images/";

$target_dir = $dirImages;
$nameFile = pathinfo($_FILES["image"]["name"], PATHINFO_FILENAME);
$extFile = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
// $target_file = $target_dir.$nameFile."_".strtotime(date("Y-m-d H:i:s")).".".$extFile;
$uploadOk = 1;
$imageFileType = strtolower($extFile);

if(getimagesize($_FILES["image"]["tmp_name"]) !== false) {
    array_push($jsondata["info"], "File is an image");
    $uploadOk = 1;
} else {
    array_push($jsondata["error"], "File is not an image.");
    $uploadOk = 0;
}
// Check if file already exists
// if (file_exists($target_file)) {
//     array_push($jsondata["error"], "Sorry, file already exists.");
//     $uploadOk = 0;
// }
// Check file size
if ($_FILES["image"]["size"] > 1700000) {
    array_push($jsondata["error"], "Sorry, your file is too large.");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    array_push($jsondata["error"], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    array_push($jsondata["error"], "Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    $path = $_FILES["image"];
    $type = $extFile;
    $data = file_get_contents( $_FILES["image"]["tmp_name"] );
    // var_dump($data);die();
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    // var_dump($base64);die();

    $jsondata["success"] = true;
    $jsondata["base64"] = $base64;
    // echo json_encode($jsondata);
    echo $jsondata["base64"];

    // if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    //     // $jsondata["success"] = "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
    //     $nameImage = $nameFile."_".strtotime(date("Y-m-d H:i:s")).".".$extFile;
    //
    //     if($_POST['id']!="undefined" && isset($_POST['id']) && !empty($_POST['id']))
    //     {
    //       db_query(0, 'select * from '.$_POST['where'].' where id="'.$_POST['id'].'"');
    //
    //       if($_POST['where']=="packages")
    //       {
    //         $whatColumn = "image";
    //       }
    //       elseif ($_POST['where']=="companies") {
    //         $whatColumn = "logo";
    //       }
    //
    //       $imagenBefore = $row[$whatColumn];
    //
    //       if (file_exists($dirImages.$imagenBefore)) {
    //         unlink($dirImages.$imagenBefore);
    //       }
    //
    //       db_update('update '.$_POST['where'].' set '.$whatColumn."="."'".$nameImage."'"." where id='".$_POST['id']."'");
    //     }
    //
    //     $jsondata["success"] = true;
    //     $jsondata["nameFile"] = $nameImage;
    //     echo json_encode($jsondata);
    // } else {
    //     // $jsondata["error"] = "Sorry, there was an error uploading your file.";
    //     $jsondata["success"] = false;
    //     echo json_encode($jsondata);
    // }
}
?>
