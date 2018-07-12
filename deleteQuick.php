<?
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();
$id = $_POST['id'];
$view = $_POST['view'];

$columnIdName = "id";

if($view=="subCategorias"){
	$columnIdName = "idSubcat";
}
elseif($view=="categorias"){
	$columnIdName = "idCat";
}


if ($view == "packages" || $view == "companies" || $view == "users" || $view == "subCategorias" || $view == "categorias")
{
	$query = "delete from {$view} where {$columnIdName}='{$id}'";

	db_query(0, $query);

	$jsondata["success"] = true;
}
else {
	$jsondata["success"] = false;
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata);
?>
