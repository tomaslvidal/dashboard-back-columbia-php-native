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
      <input type="hidden" id="view" name="view" value="vouchers"/>

      <!-- <input type="hidden" name="statusInit" id="statusInit" value="false"/> -->

      <input type="hidden" name="statusMouseOver" id="statusMouseOver" value="false"/>
      <?
      echo(breadcrumbName('Vouchers','Listado'));
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> Vouchers </div>
            <div class="card-body row">
              <div class="col-lg-8">
                <div class="table-responsive">
                  <table class="table table-bordered dataTable" data-view="vouchers" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col" data-which="id" data-state="off">ID</th>
                        <th scope="col" data-which="userId" data-where="users">Usuario</th>
                        <th scope="col" data-which="name">Nombre</th>
                        <th scope="col" data-which="description">Descripcion</th>
                        <th scope="col" data-which="stateId" data-where="states">Estado</th>
                        <th scope="col" data-which="dateCreated" data-state="off">Fecha de creación</th>
                        <th scope="col"><div style="display: block; width: 60px; height: 2px"></div></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>
                        <th><div style="display: block; width: 60px; height: 2px"></div></th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?
                        db_query(0,'select vouchers.*, states.name as stateName, users.id as userId, users.name as userName, users.lastName as userLastName from vouchers join users on vouchers.userId = users.id join states on vouchers.stateId = states.id');
                        $i=0;
                        while($i<$tot){
                          $nres = $res->data_seek($i);

                          $row = $res->fetch_assoc();
                      ?>
                      <tr data-id="row<?=$row['id']?>" id="row<?=$row['id']?>">
                        <td data-field="id" ><?=$row['id']?></td>
                        <td data-field="userId" ><?=$row['userName']." ".$row['userLastName']?></td>
                        <td data-field="name" ><?=$row['name']?></td>
                        <td data-field="description" ><?=$row['description']?></td>
                        <td data-field="stateId" ><?=$row['stateName']?></td>
                        <td data-field="dateCreated" ><?=$row['dateCreated']?></td>
                        <td style="text-align: center;">
                          <!-- <a style="padding-right: 15px;" href="<?=$dir_?>categories/add.php?id=<?=$row['idCat']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
                          <a href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-id="<?=$row['id']?>" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>
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

                .borderStyle2{
                  border-width: 2px 1px 2px 1px;
                  border-style: solid;
                }

                .borderStyle{
                  border-width: 0px 1px 0px 1px;
                  border-style: solid;
                }

                .borderColor{
                  border-color: #dee2e6;
                }
              </style>

              <div class="col-lg-4">
                <div style="height: 39px">
                </div>

                <div class="col-12 borderStyle2 borderColor" style="margin-top: 6px">
                  <div style="height: 48px;display: flex;align-items: center;padding-bottom: 2px;">
                    <h4 class="m-0">
                      Agregar
                    </h4>
                  </div>
                </div>

                <div class="card-footer small text-muted borderStyle borderColor"></div>

                <style>
                  .styleRow{
                    padding: 20px;
                    padding-top: 8px; 
                    padding-bottom: 10px
                  }
                </style>

                <div class="col-12 borderStyle2 borderColor" style="border-top: 0px;">
                  <form class="formValidate needs-validation" novalidate>
                    <div class="row styleRow">
                      <label for="userId">Usuario</label>

                      <input type="text" class="form-control" name="userId" value="" id="userId" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre de la categoría</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="name">Nombre</label>
                      
                      <input type="text" class="form-control" name="name" value="" id="name" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre de la categoría</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="description">Descripción</label>
                      
                      <input type="text" class="form-control" name="description" value="" id="description" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre de la categoría</small> -->
                    </div>
                  </form>

                  <div class="row styleRow" style="padding-bottom: 20px!important">
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