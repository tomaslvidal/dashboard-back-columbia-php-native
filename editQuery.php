<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

unset($_COOKIE['hibext_instdsigdipv2']);

$jsondata = array();

$jsondata["data"] = array();

if(substr($_POST['name'], -2)=="Id"){
  $select = "true";
}
else{
  $select = "false";
}

if($_POST['value']!='all'){
  $value = "'".$_POST['value']."'";
}
else{
  $value = "null";
}

if(!empty($_POST['name'])){
  db_update("UPDATE {$_POST['view']} SET {$_POST['name']}=".$value." WHERE id='{$_POST['id']}'");

  if(!empty($_POST['name'])){
    if($select == "true"){
      db_query(0,"SELECT * FROM ".substr($_POST['name'], 0, -2)."s"." where id='".$_POST['value']."'");

      db_query(2, "select * from ".substr($_POST['name'], 0, -2)."s");

      $options = array();

      for ($i=0;$i<$tot2;$i++){
        $nres2 = $res2->data_seek($i);
        
        $row2 = $res2->fetch_assoc();

        array_push($options, array(
          "name" => (isset($row2['lastName']) ? $row2['name']." ".$row2['lastName'] : $row2['name']),
          "value" => $row2['id']
        ));

        if($_POST['name']=="all"){
          array_push($options, array(
            "name" => 'Todos',
            "value" => 'all'
          ));
        }
      }
    }

    $jsondata["data"] = array(
      $_POST['name'] => array(
        "name" => $select == "true" ? ($_POST[$keysPOST[$i]]!="all" ? (isset($row['lastName']) ? $row['name']." ".$row['lastName'] : $row['name']) : 'Todos') : $_POST['value'],
        "value" => $select == "true" ? $_POST['value'] : $_POST['id'],
        "type" => $select == "true" ? 'select' : 'input'
      )
    );

    if($select == "true"){
      $jsondata["data"][$_POST['name']]["options"] = $options;
    }
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
