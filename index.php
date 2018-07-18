<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

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
  include("{$dir}modelPage/parts/footer.php"); include("{$dir}modelPage/secondPart.php");
?>
