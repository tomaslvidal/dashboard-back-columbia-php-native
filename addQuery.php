<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();

$jsondata["data"] = array();

$_POST = $_REQUEST;

$_POST['stateId'] = 1;

$view = $_POST['view'];

db_query(0,"select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '".$view."';");

$columnsOfTable = array();

for($r=0;$r<$tot;$r++){
  $nres = $res->data_seek($r);
        
  $row = $res->fetch_assoc();

  $columnsOfTable[$r] = $row['COLUMN_NAME'];
}

unset($_POST['PHPSESSID']); unset($_POST['view']);

/////////////
$keysPOST = array_keys($_POST);

$columns = "";

for($i=0;$i<count($keysPOST);$i++){ 
  $columns.=$keysPOST[$i].",";
}

$ultimaLetra = substr($columns, -1);

if($ultimaLetra==","){
  $columns = substr ($columns, 0, -1);
}

$values = "";

/////////////
for($d=0;$d<count($_POST);$d++){ 
  $values.="'".$_POST[$keysPOST[$d]]."'".",";
}

$ultimaLetra = substr($values, -1);

if($ultimaLetra==","){
  $values = substr ($values, 0, -1);
}

for($c=0;$c<count($columnsOfTable);$c++){
  if(!array_key_exists($columnsOfTable[$c], $_POST) && $columnsOfTable[$c]!="id"){
    $missingColumns[] = $columnsOfTable[$c];
  }
}

db_insert("INSERT INTO ".$view." (".$columns.") VALUES (".$values.")");

db_query(0, "SELECT LAST_INSERT_ID()");

$lastID = $row['LAST_INSERT_ID()'];

db_query(0, "select * from ".$view." where id='".$lastID."'");

$jsondata["data"]["id"] = array(
  "name" => $lastID,
  "value" => $lastID,
  "type" => "identifier"
);

if($tot>0){
	$jsondata["success"] = true;

  /////////////
  for($i=0;$i<count($keysPOST);$i++){
    if(substr($keysPOST[$i], -2)=="Id"){
      $select = "true";
    }
    else{
      $select = "false";
    }

    if($select == "true"){
      db_query(3,"SELECT * FROM ".substr($keysPOST[$i], 0, -2)."s"." where id='".$_POST[$keysPOST[$i]]."'");

      db_query(2, "SELECT * FROM ".substr($keysPOST[$i], 0, -2)."s");

      $options = array();

      for($e=0;$e<$tot2;$e++){
        $nres2 = $res2->data_seek($e);
        
        $row2 = $res2->fetch_assoc();

        array_push($options, array(
          "name" => (isset($row2['lastName']) ? $row2['name']." ".$row2['lastName'] : $row2['name']),
          "value" => $row2['id']
        ));
      }
    }

    $jsondata["data"][$keysPOST[$i]] = array(
      "name" => $select == "true" ? (isset($row3['lastName']) ? $row3['name']." ".$row3['lastName'] : $row3['name']) : $_POST[$keysPOST[$i]],
      "value" => $select == "true" ? $_POST[$keysPOST[$i]] : $lastID,
      "type" => $select == "true" ? 'select' : 'input'
    );

    if($select == "true"){
      $jsondata["data"][$keysPOST[$i]]["options"] = $options;
    }
  }

  /////////////
  for($g=0;$g<count($missingColumns);$g++){
    $jsondata["data"][$missingColumns[$g]] = array(
      "name" => $row[$missingColumns[$g]],
      "value" => $lastID,
      "type" => 'text'
    );
  }
}
else{
	$jsondata["success"] = false;

	$jsondata["data"] = array(
	 'message' => 'No se encontró ningún resultado.'
	);
}

sleep(1);

header('Content-type: application/json; charset=utf-8');

echo json_encode($jsondata);
?>