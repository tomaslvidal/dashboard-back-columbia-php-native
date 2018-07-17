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
      <input type="hidden" id="view" name="view" value="users"/>

      <!-- <input type="hidden" name="statusInit" id="statusInit" value="false"/> -->

      <input type="hidden" name="statusMouseOver" id="statusMouseOver" value="false"/>
      <?
      echo(breadcrumbName('Usuarios','Listado'));
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> Usuarios</div>
            <div class="card-body row">
              <div class="col-lg-8">
                <div class="table-responsive">
                <table class="table table-bordered" data-view="users" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col" data-which="id" data-state="off">ID</th>
                      <th scope="col" data-which="user">Usuario</th>
                      <th scope="col" data-which="password">Contraseña</th>
                      <th scope="col" data-which="name">Nombre</th>
                      <th scope="col" data-which="lastName">Apellido</th>
                      <th scope="col" data-which="email">Email</th>
                      <th scope="col" data-which="telephone">Teléfono</th>
                      <th scope="col" data-which="stateId" data-where="states">Estado</th>
                      <th scope="col" data-which="dateCreated" data-state="off">Fecha Creacion</th>
                      <th scope="col"><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Usuario</th>
                      <th>Contraseña</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Email</th>
                      <th>Teléfono</th>
                      <th>Estado</th>
                      <th>Fecha Creacion</th>
                      <th><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?
                      db_query(0,'select users.*, states.id as stateId, states.name as stateName from users join states on users.stateId = states.id');
                      $i=0;
                      while($i<$tot)
                      {
                        $nres = $res->data_seek($i);
                        $row = $res->fetch_assoc();
                    ?>
                    <tr data-id="row<?=$row['id']?>" id="row<?=$row['id']?>">
                      <td data-field="id"><?=$row['id']?></td>
                      <td data-field="user" ><?=$row['user']?></td>
                      <td data-field="password" ><?=$row['password']?><!-- ******** --></td>
                      <td data-field="name" ><?=$row['name']?></td>
                      <td data-field="lastName" ><?=$row['lastName']?></td>
                      <td data-field="email" ><?=$row['email']?></td>
                      <td data-field="telephone" ><?=$row['telephone']?></td>
                      <td data-field="stateId" ><?=$row['stateName']?></td>
                      <td style="text-align: center;"><?=$row['dateCreated']?></td>
                      <td style="text-align: center;">
                        <!-- <a style="padding-right: 15px;" href="<?=$dir_?>categories/add.php?id=<?=$row['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
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
                      <label for="name">Nombre</label>

                      <input type="text" class="form-control" name="name" value="" id="name" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre del usuario</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="lastName">Apellido</label>

                      <input type="text" class="form-control" name="lastName" value="" id="lastName" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre del usuario</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="user">Usuario</label>

                      <input type="text" class="form-control" name="user" value="" id="user" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el usuario</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="password">Contraseña</label>

                      <input type="password" class="form-control" name="password" value="" id="password" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre del usuario</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="email">Email</label>

                      <input type="email" class="form-control" name="email" value="" id="email" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre del usuario</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="telephone">Teléfono</label>

                      <input type="tel" class="form-control" name="telephone" value="" id="telephone" placeholder="" required="">

                      <!-- <small id="nameHelp" class="form-text text-muted">Escribe el nombre del usuario</small> -->
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

                  <div class="row styleRow" style="padding-bottom: 20px">
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
