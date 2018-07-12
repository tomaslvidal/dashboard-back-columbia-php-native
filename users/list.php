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
      <input type="hidden" id="view" name="view" value="categorias"/>
      <!-- <input type="hidden" name="statusInit" id="statusInit" value="false"/> -->
      <input type="hidden" name="statusMouseOver" id="statusMouseOver" value="false"/>
      <?
      echo(breadcrumbName('Categorías','Listado'));
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> Categorías </div>
            <div class="card-body row">
              <div class="col-lg-8">
                <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Categoría</th>
                      <th><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Categoría</th>
                      <th><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?
                      db_query(0,'select * from categorias');
                      $i=0;
                      while($i<$tot)
                      {
                        $nres = $res->data_seek($i);
                        $row = $res->fetch_assoc();
                    ?>
                    <tr data-id="row<?=$row['idCat']?>" id="row<?=$row['idCat']?>">
                      <td data-field="id" ><?=$row['idCat']?></td>
                      <td data-field="category" ><?=$row['nombre']?></td>
                      <td style="text-align: center;">
                        <!-- <a style="padding-right: 15px;" href="<?=$dir_?>categories/add.php?id=<?=$row['idCat']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
                        <a href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-id="<?=$row['idCat']?>" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                    <?
                      $i++;
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              </div>
              <style>
              #iconLoading{
                display: none;
                align-self: center;
                margin-left: 8px;
                color: #16a085;
              }
              </style>
              <div class="col-lg-4">
                <div style="height: 39px">
                </div>
                <div class="col-12" style="margin-top: 6px;border: 2px solid #dee2e6; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                  <div style="height: 48px;display: flex;align-items: center;padding-bottom: 2px;">
                    <h4 class="m-0">Agregar
                      <!-- <span class="badge badge-secondary" style="background-color: #007bff;font-size: 45%;">New</span> -->
                    </h4>
                  </div>
                </div>
                <div class="card-footer small text-muted" style="border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;"></div>
                <div class="col-12" style="border: 2px solid #dee2e6; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; border-top: 0px;">
                  <form class="formValidate needs-validation" novalidate>
                    <div class="row" style="padding: 20px;padding-top: 8px; padding-bottom: 10px">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" name="name_" value="" id="name" placeholder="" required="">
                      <small id="nameHelp" class="form-text text-muted">Escribe el nombre de la categoría</small>
                    </div>
                  </form>
                  <div class="row" style="padding: 20px; padding-top: 8px; padding-bottom: 20px">
                    <div style="display: flex; flex: 1; padding-left: 5px;">
                      <div id="addItem" style="display: flex; align-items: center; cursor: pointer;">
                        <i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 20px; color: #16a085; margin-right: 4px;"></i>
                        <span>Agregar</span>
                      </div>
                      <div id="iconLoading">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
  <?
    include("{$dir}modelPage/secondPart.php");
  ?>
</body>

</html>
