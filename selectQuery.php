<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

if($_POST['init']=="success"){
  $jsondata = array();
  
  $jsondata["data"] = array();

  $query = "SELECT * FROM ".$_POST['dataWhere'];
  
  db_query(0,$query);

  if($tot>0){
    $jsondata["success"] = true;

    for($i=0; $i < $tot; $i++){
      $nres = $res->data_seek($i);

      $row = $res->fetch_assoc();

      array_push($jsondata["data"],array(
        "name" => !isset($row['lastName']) ? $row['name'] : $row['name']." ".$row['lastName'],
        "id" => $row['id']
      ));
    }
  }
  else{
  	$jsondata["success"] = false;

  	$jsondata["data"] = array(
  	 'message' => 'Error'
  	);
  }

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
