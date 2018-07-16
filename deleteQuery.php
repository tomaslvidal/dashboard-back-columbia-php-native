<?
// error_reporting(E_ALL);

// ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();

$id = $_POST['id'];

$view = $_POST['view'];

$query = "delete from {$view} where id='{$id}'";

db_query(0, $query);

$jsondata["success"] = true;

header('Content-type: application/json; charset=utf-8');

echo json_encode($jsondata);
?>
