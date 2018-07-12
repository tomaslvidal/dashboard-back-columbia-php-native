<?
error_reporting(E_ALL);
ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/generalPanel.php");

$category = isset($_POST['category']) ? $_POST['category'] : '';

$id = isset($_POST['id']) ? $_POST['id'] : '';

$jsondata = array();

$jsondata["data"] = array();

if(!empty($category))
{
  db_update("UPDATE categorias SET nombre='{$category}' WHERE idCat='{$id}'");

  db_query(0,"SELECT * FROM categorias where idCat='".$id."'");

  if(!empty($category))
  {
    $jsondata["data"] = array_merge($jsondata["data"], array(
      "category" => array(
        "name" => $row['nombre'],
        "value" => $row['idCat'],
        "type" => 'input'
      )
    ));
  }

  $jsondata["id"] = $id;

  $jsondata["success"] = true;
}
else
{
	$jsondata["success"] = false;

	$jsondata["data"] = array(
	 'message' => 'Error'
	);
}

header('Content-type: application/json; charset=utf-8');

echo json_encode($jsondata);
?>
