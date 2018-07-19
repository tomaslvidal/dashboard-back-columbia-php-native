<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

$jsondata = array();

$jsondata["data"] = array();

$_POST = $_GET;

$_POST['stateId'] = isset($_POST['stateId']) ? $_POST['stateId'] : 1;

if($_POST['view']=="voucherUsers"){
  unset($_POST['stateId']);
}

$view = $_POST['view'];

// if($view=="voucherUsers"){
//   $view = "users";

//   db_query(0, "select * from ".$view." where id=".$_GET['userId']." limit 1");

//   $_POST = $row;
// }

function getColumnsTable($view){
  global $res;

  global $row;

  global $tot;

  db_query(0,"select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '".$view."';");

  $columnsOfTable = array();

  for($r=0;$r<$tot;$r++){
    $nres = $res->data_seek($r);
          
    $row = $res->fetch_assoc();

    $columnsOfTable[$r] = $row['COLUMN_NAME'];
  }

  return $columnsOfTable;
}

$columnsOfTable = getColumnsTable($view);

unset($_POST['view']);

/////////////

function getColumnsForPost($posts){
  $keysPOST = array_keys($posts);

  $columns = "";

  for($i=0;$i<count($keysPOST);$i++){ 
    $columns.=$keysPOST[$i].",";
  }

  $ultimaLetra = substr($columns, -1);

  if($ultimaLetra==","){
    $columns = substr ($columns, 0, -1);
  }

  $return = array($columns, $keysPOST);

  return $return;
}

$columns = getColumnsForPost($_POST);

$keysPOST = $columns[1];

$columns = $columns[0];

/////////////

function getValuesOfColumns($columns_){
  global $_POST;

  $values = "";

  for($d=0;$d<count($_POST);$d++){
    if($_POST[$columns_[$d]]!="all"){
      $values.="'".$_POST[$columns_[$d]]."'".",";
    }
    else{
      $values.="null,";
    }
  }

  $ultimaLetra = substr($values, -1);

  if($ultimaLetra==","){
    $values = substr ($values, 0, -1);
  }

  return $values;
}

$values = getValuesOfColumns($keysPOST);

function getMissingColumns($columnsOfTable_){
  global $_POST;

  $missingColumns = "";
  
  for($c=0;$c<count($columnsOfTable_);$c++){
    if(!array_key_exists($columnsOfTable_[$c], $_POST) && $columnsOfTable_[$c]!="id"){
      $missingColumns[] = $columnsOfTable_[$c];
    }
  }

  if($missingColumns==""){
    return null;
  }
  else{
    return $missingColumns;
  }
}

$missingColumns = getMissingColumns($columnsOfTable);

// for($c=0;$c<count($columnsOfTable);$c++){
//   if(!array_key_exists($columnsOfTable[$c], $_POST) && $columnsOfTable[$c]!="id"){
//     $missingColumns[] = $columnsOfTable[$c];
//   }
// }

$query = "INSERT INTO ".$view." (".$columns.") VALUES (".$values.")";

db_insert($query);

db_query(0, "SELECT LAST_INSERT_ID()");

$lastID = $row['LAST_INSERT_ID()'];

if($view=="voucherUsers"){
  db_query(0, "select * from users where id='".$_POST['userId']."'");

  $_POST = $row;

  $columns = getColumnsForPost($_POST);

  $keysPOST = $columns[1];
}
else{
  db_query(0, "select * from ".$view." where id='".$lastID."'");
}

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
      $options = array();

      db_query(3,"SELECT * FROM ".substr($keysPOST[$i], 0, -2)."s"." where id='".$_POST[$keysPOST[$i]]."'");

      db_query(2, "SELECT * FROM ".substr($keysPOST[$i], 0, -2)."s");


      for($e=0;$e<$tot2;$e++){
        $nres2 = $res2->data_seek($e);
        
        $row2 = $res2->fetch_assoc();

        array_push($options, array(
          "name" => (isset($row2['lastName']) ? $row2['name']." ".$row2['lastName'] : $row2['name']),
          "value" => $row2['id']
        ));

        if($keysPOST[$i]=="user" && $_POST[$keysPOST[$i]]=="all"){
          array_push($options, array(
            "name" => 'Todos',
            "value" => 'all'
          ));
        }
      }
    }

    $jsondata["data"][$keysPOST[$i]] = array(
      "name" => $select == "true" ? ($_POST[$keysPOST[$i]]!="all" ? (isset($row3['lastName']) ? $row3['name']." ".$row3['lastName'] : $row3['name']) : 'Todos')  : $_POST[$keysPOST[$i]],
      "value" => $select == "true" ? $_POST[$keysPOST[$i]] : $lastID,
      "type" => $select == "true" ? 'select' : 'input'
    );

    if($select == "true"){
      $jsondata["data"][$keysPOST[$i]]["options"] = $options;
    }
  }

  /////////////
  if(isset($missingColumns)){
    for($g=0;$g<count($missingColumns);$g++){
      $jsondata["data"][$missingColumns[$g]] = array(
        "name" => $row[$missingColumns[$g]],
        "value" => $lastID,
        "type" => 'text'
      );
    }
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