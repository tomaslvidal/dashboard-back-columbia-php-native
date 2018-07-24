<?
// error_reporting(E_ALL);

// ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();

$id = $_POST['id'];

$view = $_POST['view'];

if($view=="destinationsImage"){
	db_query(0, 'select * from destinations where id="'.$_POST['id'].'"');

	$dirImages = $dir."uploads/images/";

	$fileMoreRoute = $dirImages . $row['image'.$_POST['name']];

	if(file_exists($fileMoreRoute)){
		unlink($fileMoreRoute);

		db_update("update destinations set image{$_POST['name']} = '' where id=".$_POST['id']);
	}
}
elseif($view=="destinationsFile"){
	db_query(0, 'select * from vouchers where id="'.$_POST['id'].'"');

	$dirImages = $dir."uploads/files/";

	$fileMoreRoute = $dirImages . $row['fileName'];

	if(file_exists($fileMoreRoute)){
		unlink($fileMoreRoute);

		db_update("update vouchers set fileName = '' where id=".$_POST['id']);
	}
}
elseif($view=="destinations"){
	db_query(0, 'select * from destinations where id="'.$_POST['id'].'" limit 1');

	for ($i=1; $i <= 5; $i++){ 
		if($row['image'.$i]!=""){
			$dirImages = $dir."uploads/images/";

			$fileMoreRoute = $dirImages . $row['image'.$i];

			if(file_exists($fileMoreRoute)){
				unlink($fileMoreRoute);
			}
		}
	}

	$query = "delete from {$view} where id='{$id}'";

	db_query(0, $query);
}
elseif($view=="vouchers"){
	db_query(0, 'select * from vouchers where id="'.$_POST['id'].'" limit 1');

	if($row['fileName']!=""){
		$dirImages = $dir."uploads/files/";

		if(file_exists($dirImages.$row['fileName'])){
			unlink($dirImages.$row['fileName']);
		}
	}

	$query = "delete from {$view} where id='{$id}'";

	db_query(0, $query);
}
else{
	$query = "delete from {$view} where id='{$id}'";

	db_query(0, $query);
}

$jsondata["success"] = true;

header('Content-type: application/json; charset=utf-8');

echo json_encode($jsondata);
?>
