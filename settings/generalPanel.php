<?php
include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/dirsGlobal.php");

// if(!isset($_COOKIE['idSession_adm']))
// {
//   header("Location: {$dirNew_}login-adm.php");
// }
// else
// {
//   session_set_cookie_params(1800);
//   session_id($_COOKIE['idSession_adm']);
//   session_start();

//   if(!isset($_SESSION['logged_adm']))
//   {
//     header("Location: {$dirNew_}login-adm.php");
//   }
//   else
//   {
//     if($_SESSION['logged_adm']=="false")
//     {
//       header("Location: {$dirNew_}login-adm.php");
//     }
//   }
// }

date_default_timezone_set("America/Argentina/Buenos_Aires");

include("{$dir}settings/config.site.inc.php");
?>
