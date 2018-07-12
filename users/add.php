<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/generalPanel.php");

$category = isset($_POST['category']) ? $_POST['category'] : '';

$jsondata = array();

$jsondata["data"] = array();

if(!empty($category))
{
  db_insert("INSERT INTO categorias (nombre) VALUES ('{$category}')");

  db_query(0, "SELECT LAST_INSERT_ID()");

  $lastID = $row['LAST_INSERT_ID()'];

  db_query(0, "select * from categorias where idCat='".$lastID."'");

  if( $tot > 0 )
  {
  	$jsondata["success"] = true;

    $jsondata["data"] = array(
      "id" => array(
        "name" => $row['idCat'],
        "value" => $row['idCat'],
        "type" => "identifier"
      ),
      "category" => array(
        "name" => $row['nombre'],
        "value" => $row['idCat'],
        "type" => "input"
      )
    );
  }
  else
  {
  	$jsondata["success"] = false;

  	$jsondata["data"] = array(
  	 'message' => 'No se encontró ningún resultado.'
  	);
  }
}
else
{
	$jsondata["success"] = false;

	$jsondata["data"] = array(
	 'message' => 'Error'
	);
}

sleep(1);

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata);
?>
