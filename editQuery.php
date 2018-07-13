<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$id = isset($_POST['id']) ? $_POST['id'] : '';

$jsondata = array();

$jsondata["data"] = array();

if(!empty($_POST['name'])){
  db_update("UPDATE {$_POST['view']} SET {$_POST['name']}={$_POST['value']} WHERE id='{$_POST['id']}'");

  db_query(0,"SELECT * FROM {$_POST['view']} where id='".$_POST['id']."'");

  if(!empty($_POST['name'])){
    $jsondata["data"] = array_merge($jsondata["data"], array(
      "{$_POST['name']}" => array(
        "name" => $row['nombre'],
        "value" => $row['id'],
        "type" => 'input'
      )
    ));
  }

  $jsondata["id"] = $_POST['id'];

  $jsondata["success"] = true;
}
else{
	$jsondata["success"] = false;

	$jsondata["data"] = array(
	 'message' => 'Error'
	);
}

header('Content-type: application/json; charset=utf-8');

echo json_encode($jsondata);
?>
