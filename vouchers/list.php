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
                        <!-- <th scope="col" data-which="userId" data-where="users">Usuario</th> -->
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
                        <!-- <th>Usuario</th> -->
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>
                        <th><div style="display: block; width: 60px; height: 2px"></div></th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?
                        db_query(0,'select vouchers.*, states.name as stateName from vouchers left join states on vouchers.stateId = states.id');
                        $i=0;
                        while($i<$tot){
                          $nres = $res->data_seek($i);

                          $row = $res->fetch_assoc();
                      ?>
                      <tr data-id="row<?=$row['id']?>" id="row<?=$row['id']?>">
                        <td data-field="id" ><?=$row['id']?></td>
                        <!-- <td data-field="userId" ><?=$row['userId'] == null ? 'Todos' : ($row['userName']." ".$row['userLastName'])?></td> -->
                        <td data-field="name" ><?=$row['name']?></td>
                        <td data-field="description" ><?=$row['description']?></td>
                        <td data-field="stateId" ><?=$row['stateName']?></td>
                        <td data-field="dateCreated" ><?=$row['dateCreated']?></td>
                        <td style="text-align: center;">
                          <div class="flexInit">

                            <div class="differentIcons">
                              <div class="flexInit twoCenter">
                                <i class="modalUser modalVarious fas fa-user-plus"></i>
                              </div>

                              <div class="flexInit twoCenter">
                                <i class="modalUpload modalVarious fas fa-cloud-upload-alt"></i>
                              </div>
                            </div>

                            <div class="flexInit twoCenter">
                              <a style="display: flex" href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                          </div>
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
<!--                     <div class="row styleRow">
                      <label for="userId">Usuario</label>

                      <select class="custom-select" name="userId" id="userId">
                        <option value="all">Todos</option> -->
                      <?
                        // db_query(0, "select * from users");

                        // for($i=0;$i<$tot;$i++){
                        //   $nres = $res->data_seek($i);
      
                        //   $row = $res->fetch_assoc(); 
                      ?>
                          <!-- <option value="<?=$row['id']?>"><?=!isset($row['lastName']) ? $row['name'] : $row['name']." ".$row['lastName']?></option> -->
                      <?
                        // }
                      ?>
                      <!-- </select> -->

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre de la categoría</small> -->
                    <!-- </div> -->

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

                    <div class="row styleRow">
                      <label for="stateId">Estado</label>

                      <select class="custom-select" name="stateId" id="stateId">
                      <?
                        db_query(0, "select * from states order by name DESC");

                        for($d=0;$d<$tot;$d++){
                          $nres = $res->data_seek($d);
      
                          $row = $res->fetch_assoc(); 
                        
                      ?>
                          <option value="<?=$row['id']?>"><?=!isset($row['lastName']) ? $row['name'] : $row['name']." ".$row['lastName']?></option>
                      <?
                        }
                      ?>
                      </select>

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
  include("{$dir}modelPage/parts/footer.php"); include("{$dir}modelPage/secondPart.php");
?>
</body>

</html>