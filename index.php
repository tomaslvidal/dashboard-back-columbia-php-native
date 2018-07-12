<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

// $indicesServer = array('PHP_SELF',
// 'argv',
// 'argc',
// 'GATEWAY_INTERFACE',
// 'SERVER_ADDR',
// 'SERVER_NAME',
// 'SERVER_SOFTWARE',
// 'SERVER_PROTOCOL',
// 'REQUEST_METHOD',
// 'REQUEST_TIME',
// 'REQUEST_TIME_FLOAT',
// 'QUERY_STRING',
// 'DOCUMENT_ROOT',
// 'HTTP_ACCEPT',
// 'HTTP_ACCEPT_CHARSET',
// 'HTTP_ACCEPT_ENCODING',
// 'HTTP_ACCEPT_LANGUAGE',
// 'HTTP_CONNECTION',
// 'HTTP_HOST',
// 'HTTP_REFERER',
// 'HTTP_USER_AGENT',
// 'HTTPS',
// 'REMOTE_ADDR',
// 'REMOTE_HOST',
// 'REMOTE_PORT',
// 'REMOTE_USER',
// 'REDIRECT_REMOTE_USER',
// 'SCRIPT_FILENAME',
// 'SERVER_ADMIN',
// 'SERVER_PORT',
// 'SERVER_SIGNATURE',
// 'PATH_TRANSLATED',
// 'SCRIPT_NAME',
// 'REQUEST_URI',
// 'PHP_AUTH_DIGEST',
// 'PHP_AUTH_USER',
// 'PHP_AUTH_PW',
// 'AUTH_TYPE',
// 'PATH_INFO',
// 'ORIG_PATH_INFO') ;

// echo '<table cellpadding="10">' ;
// foreach ($indicesServer as $arg) {
//     if (isset($_SERVER[$arg])) {
//         echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
//     }
//     else {
//         echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
//     }
// }
// echo '</table>' ; 

// die();

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

include("{$dir}modelPage/inc/breadcrumb.php");

include("{$dir}modelPage/firstPart.php");
?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?
    include("{$dir}modelPage/parts/navbar.php");
  ?>
    <div class="container-fluid">
      <?
        echo(breadcrumbName());
      ?>
      <div class="row">
        <div class="col-12">

        </div>
      </div>
    </div>
<?
  include("{$dir}modelPage/secondPart.php");
?>
