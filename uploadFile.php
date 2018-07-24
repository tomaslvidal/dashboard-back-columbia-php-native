<?php
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();

$extFile = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

$nameFile = uniqid()."_".$_POST['view'][0].".".$extFile;

$route = $dir . "uploads/files/" . $nameFile;

if(($extFile!="bat" && $extFile!="exe") && $_FILES["file"]["size"] < 1700000){
	db_query(0, 'select * from vouchers where id="'.$_POST['id'].'" limit 1');

	if($tot==1 && $row['fileName']!=""){
		if(file_exists($dir . "uploads/files/".$row['fileName'])){
		  unlink($dir . "uploads/files/".$row['fileName']);
		}
	}

	if(move_uploaded_file($_FILES['file']['tmp_name'], $route)){
		$jsondata["success"] = true;

		$jsondata['nameFile'] = $nameFile;

		db_update("update vouchers set fileName = '{$nameFile}' where id='{$_POST['id']}'");
	}
}
else{
	$jsondata["success"] = false;
	
	if($_FILES["file"]["size"] > 1700000){
		$jsondata["reason"] = "El archivo supera el peso permitido.";
	}
	else{
		$jsondata["reason"] = "Extensión invalida.";
	}
}

sleep(1);

header('Content-type: application/json; charset=utf-8');

echo json_encode($jsondata);
?>