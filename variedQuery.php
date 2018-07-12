<?php
// error_reporting(E_ALL);
//
// ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/generalPanel.php");

include("{$dir}settings/functions.php");

// var_dump("TESTx1");die();
$table = verifyPost('where');
if(!empty($table))
{
  $user = verifyPost('user');
  $panel = verifyPost('panel');
  $idCompany = verifyPost('idCompany');
  $action = verifyPost('action');
  $id = verifyPost('id');

  if($table=='users'){
    $columns = "user, idCompany, password, email, name, lastname, telephone, typeDocument, nroDocument, centerCost, panel, fechaModificacion";

    //Comprobar si existe usuario
    db_query(0,"select * from {$table} where user='{$user}' and panel='{$panel}'");

    //Comprobar si la empresa ya tiene Usuario
    db_query(1,"select * from {$table} where idCompany='{$idCompany}' and panel='{$panel}'");

    if(empty($action))
    {
      //Comprobar si existe usuario
      if($tot==0)
      {
        //Comprobar si la empresa ya tiene Usuario
        if($tot1==0)
        {
          $query = textQuery($columns);
          // var_dump("INSERT {$table} ".$query);die()
          db_insert("INSERT {$table}".$query);

          $email = verifyPost('email');
          if(verifyPost('checkWelcome') == 'true' && !empty($email) )
          {
            $subject = "Columbia - ¡Bienvenido!";

            $headers  = 'MIME-Version: 1.0' . "\r\n";

            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

            $headers .= 'Content-Transfer-Encoding: base64' . "\r\n";

            $headers .= 'To: '.verifyPost('email').'' . "\r\n";

            $headers .= 'From: Columbia <welcome@columbia.com.ar>' . "\r\n";

            // if($email_copia_oculta<>'')
            // {
            // 	$headers .= 'Bcc: soporte@aptek.com.ar,'.$email_copia_oculta.' ' . "\r\n";
            // }
            // else
            // {
            	$headers .= 'Bcc: soporte@aptek.com.ar' . "\r\n";
            // }

            // $headers .= 'Reply-To: '.$emailReserva. "\r\n" ;

            // Mensaje

            $message = "";

            // $message .= "<hr><br><font class='bodyFont'><b>Has sido autorizado para acceder a nuestro Sitio</b></font><br>";
            //
            // $message .= "<font class='bodyFont'>"."ddddddddd"."</font>";
            //
            // $message.="<br><br><font class='bodyFont'>"."dddddd"."</font>";

            ob_start();

            $subheader_text = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

            $usuario_text = verifyPost('user');

            $password_text = verifyPost('password');

            include $dir.'emailHTML.php';

            $message.= ob_get_clean();

            $messagelpl2 = chunk_split(base64_encode($message));

            // Mensaje

            mail("", utf8_decode($subject), $messagelpl2, $headers);
          }
          header("Location: {$dir_}{$table}/list.php");
        }
        else
        {
          $_SESSION['alert'] = array(
            'reason' => 'La empresa ya tiene un usuario asociado',
            'type' => 'warning'
          );
          header("Location: {$dir_}{$table}/add.php");
        }
      }
      else{
        $_SESSION['alert'] = array(
          'reason' => 'Ya existe el usuario',
          'type' => 'warning'
        );
        header("Location: {$dir_}{$table}/add.php");
      }
    }
    else
    {
      db_query(3,"select * from {$table} where user='{$user}' and panel='{$panel}' and id!='{$id}'");

      //Comprobar si la empresa ya tiene Usuario
      db_query(4,"select * from {$table} where idCompany='{$idCompany}' and panel='{$panel}' and id!='{$id}'");
      //Comprobar si existe usuario
      if($tot3==0)
      {
        //Comprobar si la empresa ya tiene Usuario
        if($tot4==0)
        {
          $query = textQuery($columns);
          // var_dump("UPDATE {$table}".$query."where id={$id}");die();
          db_update("UPDATE {$table}".$query."where id={$id}");

          $_SESSION['alert'] = array(
            'reason' => 'Usuario actualizado',
            'type' => 'success'
          );

          header("Location: {$dir_}{$table}/add.php?id={$id}");
        }
        else
        {
          $_SESSION['alert'] = array(
            'reason' => 'La empresa ya tiene un usuario asociado',
            'type' => 'warning'
          );
          header("Location: {$dir_}{$table}/add.php?id={$id}");
        }
      }
      else
      {
        $_SESSION['alert'] = array(
          'reason' => 'Ya existe el usuario',
          'type' => 'warning'
        );
        header("Location: {$dir_}{$table}/add.php?id={$id}");
      }
    }
  }
  elseif($table=='companies')
  {
    if(empty($action))
    {
      $imgForm = verifyPost('image');

      uploadFileBase64($imgForm, $table, $id);

      $columns = "name, typeTaxAir, taxAir, markupHotel, dk, fechaModificacion".(!empty($imgForm) ? ", image" : "");
      $query = textQuery($columns);
      // var_dump($query);die();
      db_insert("INSERT {$table} ".$query);
      header("Location: {$dir_}{$table}/list.php");
    }
    else
    {
      $imgForm = verifyPost('image');

      uploadFileBase64($imgForm, $table, $id);

      $columns = "name, typeTaxAir, taxAir, markupHotel, dk, fechaModificacion".(!empty($imgForm) ? ", image" : "");
      $query = textQuery($columns);
      // var_dump($query);die();
      db_update("UPDATE {$table}".$query."where id={$id}");
      header("Location: {$dir_}{$table}/add.php?id={$id}");
    }
  }
  elseif($table=='packages')
  {

    if(empty($action))
    {
      $imgForm = verifyPost('image');

      uploadFileBase64($imgForm, $table, $id);

      $columns = "category, subCategory, since, until, title, subtitle, price, description, iconFor, checkSlider, checkHome, fechaModificacion".(!empty($imgForm) ? ", image" : "");
      $query = textQuery($columns);
      // var_dump($query);die();
      db_insert("INSERT {$table} ".$query);
      header("Location: {$dir_}{$table}/list.php");
    }
    else
    {
      $imgForm = verifyPost('image');

      uploadFileBase64($imgForm, $table, $id);

      $columns = "category, subCategory, since, until, title, subtitle, price, description, iconFor, checkSlider, checkHome, fechaModificacion".(!empty($imgForm) ? ", image" : "");

      $query = textQuery($columns);
      // var_dump($query);die();
      db_update("UPDATE {$table}".$query."where id={$id}");
      header("Location: {$dir_}{$table}/add.php?id={$id}");
    }
  }
}

?>
