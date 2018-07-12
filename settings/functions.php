<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('America/Argentina/Buenos_Aires');

function verifyPost($value, $withTilde = "no")
{
  $returnx = "";

  if(isset($_POST[$value]) && !empty($_POST[$value]))
  {
    if($value=="panel")
    {
      $returnx = onlyTwoValues('user', 'adm', $value);
    }
    // elseif($value=="image"){
    //   $returnx = "/columbiaAPP/uploads/images/".$_POST[$value];
    // }
    elseif($value=="typeTaxAir")
    {
      $returnx = onlyTwoValues('fee', 'markup', $value);
    }
    elseif($value=="typeDocument")
    {
      $returnx = onlyTwoValues('dni', 'pasaporte', $value);
    }
    elseif($value=="checkWelcome")
    {
      $returnx = onlyTwoValues('false', 'true', $value);
    }
    elseif($value=="since")
    {
      $date = str_replace('/', '-', $_POST[$value]);
      $returnx = date('Y-m-d',strtotime($date));
    }
    elseif($value=="until")
    {
      $date = str_replace('/', '-', $_POST[$value]);
      $returnx = date('Y-m-d',strtotime($date));
    }
    elseif($value=="idCompany")
    {
      $valor = $_POST[$value];
      db_query(99,"select * from companies where estado='1' and id={$valor}");
      global $tot99;
      if($tot99>0){
        $returnx = $valor;
      }
      else{
        $returnx = '1';
      }
    }
    else
    {
      $returnx = $_POST[$value];
    }

    return $returnx;
  }
  else{
    if($value=="panel"){
      $returnx = 'user';
    }
    elseif($value=="typeTaxAir"){
      $returnx = 'fee';
    }
    elseif($value=="checkWelcome"){
      $returnx = 'false';
    }
    elseif($value=="idCompany"){
      $returnx = '1';
    }
    elseif($value=="fechaModificacion"){
      $returnx = date('Y-m-d H:i:s');
    }
    elseif($value=="typeDocument"){
      $returnx = 'dni';
    }
    else{
      $returnx = "";
    }

    return $returnx;
  }


}

function onlyTwoValues($param1, $param2, $value=""){
  $valFunction = ($_POST[$value] != $param1 && $_POST[$value] != $param2) ? $param1 : $_POST[$value];
  return $valFunction;
}

function uploadFileBase64($imgForm, $where, $id = "")
{
  if(!empty($imgForm)){

    $dirImages = $_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/"."uploads/images/";

    $img = $imgForm;

    $img = explode(",",$img);

    $data = base64_decode($img[1]);

    $fileName = uniqid()."_".$where[0].'.png';

    $fileMoreRoute = $dirImages . $fileName;

    $fp = fopen($fileMoreRoute, "w");

    fwrite($fp, $data);

    fclose($fp);

    $_POST['image'] = $fileName;

    if(!empty($id))
    {
      db_query(98, 'select * from '.$where.' where id="'.$id.'"');

      global $row98;

      $imagenBefore = $row98['image'];

      if(!empty($imagenBefore))
      {
        if (file_exists($dirImages.$imagenBefore)) {
          unlink($dirImages.$imagenBefore);
        }
      }
    }

    return $fileName;
  }
  else{
    return "";
  }
}

function textQuery($columns){
  $values_ = explode( ',', $columns);
  $values = "";

  for ($i=0; $i < count($values_); $i++)
  {
    $valueColumn = trim($values_[$i]);
    $val = verifyPost($valueColumn);
    $comillas = "'";

    // if($valueColumn=="imageUpload")
    // {
    //   if(verifyPost('where') == "packages"){
    //     $valueColumn = "image";
    //   }
    //   elseif (verifyPost('where') == "companies") {
    //     $valueColumn = "logo";
    //   }
    // }
    $values.= $valueColumn."=".$comillas.$val.$comillas.",";

  }

  $ultimaLetra = substr($values, -1);
  if($ultimaLetra==",")
  {
    $values = substr ($values, 0, -1);
  }

  // $where = verifyPost('where');

  $query_ = " SET {$values}";

  return $query_;
}
?>
