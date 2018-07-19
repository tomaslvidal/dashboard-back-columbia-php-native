<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

include("{$dir}modelPage/inc/breadcrumb.php");

include("{$dir}modelPage/firstPart.php");
?>
<body id="page-top">
    <style>
      .card{
        padding: 15px 15px 15px;
        color: #333;
      }

      form{
        width: 100%;
      }
    </style>

    <input type="hidden" id="view" name="view" value="voucherUsers"/>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="padding-top: 5px;">
          <div class="card">
            <div class="header">
              <h4 class="title">Agregar Usuario</h4>
            </div>
            
            <div class="content">
              <div class="row">
                <form class="formValidate needs-validation modalForm" novalidate>
                  <input type="hidden" id="voucherId" name="voucherId" value="<?=$_GET['id']?>"/>

                  <div class="flexInit divSelect" style="flex-basis: 100%; padding-top: 15px; padding-bottom: 0px">
                    <div class="form-group" style="padding-left: 15px; padding-right: 15px">
                        <label for="userId">Usuario</label>

                        <select class="custom-select" name="userId" id="userId">
                        <?
                        db_query(0, "select voucherUsers.voucherId, users.id, users.name, users.lastName from users left join voucherUsers on users.id = voucherUsers.userId where voucherUsers.voucherId IS NULL or voucherUsers.voucherId!=".$_GET['id'].' group by id');

                        for($i=0;$i<$tot;$i++){
                          $nres = $res->data_seek($i);
      
                          $row = $res->fetch_assoc();

                          db_query(1, "select * from voucherUsers where voucherId=".$_GET['id']." and userId=".$row['id']." limit 1");

                          if($tot1<1){
                        ?>
                          <option value="<?=$row['id']?>"><?=!isset($row['lastName']) ? $row['name'] : $row['name']." ".$row['lastName']?></option>
                        <?
                          }
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-group" id="addItem" data-remove="true" style="padding-bottom: 7px; display: flex; align-items: flex-end; cursor: pointer;">
                      <div style="display: flex;align-items: center;">
                        <i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 20px; color: #16a085; margin-right: 4px;"></i>
                        
                        <span>Agregar</span>

                        <div id="iconLoading">
                          <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="emptyUser" style="padding: 15px; padding-top: 10px">
                    <span>No hay mas usuarios para agregar.</span>
                  </div>
                </form>

                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table table-bordered" data-view="users" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th data-which="id" data-state="off" scope="col">ID</th>
                          <th data-which="user" data-state="off" scope="col">Usuario</th>
                          <th data-which="name" data-state="off" scope="col">Nombre</th>
                          <th data-which="lastName" data-state="off" scope="col">Apellido</th>
                          <th data-which="email" data-state="off" scope="col">Email</th>
                          <th data-which="telephone" data-state="off" scope="col">Teléfono</th>
                          <th scope="col"><div style="display: block; width: 60px; height: 2px"></div></th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>ID</th>
                          <th>Usuario</th>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Email</th>
                          <th>Teléfono</th>
                          <th><div style="display: block; width: 60px; height: 2px"></div></th>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?
                          db_query(0,'select voucherUsers.id as voucherId, users.*, states.name as stateName from voucherUsers join users on voucherUsers.userId = users.id join states on users.stateId = states.id where voucherUsers.voucherId = "'.$_GET['id'].'"');

                          $i=0;

                          while($i<$tot)
                          {
                            $nres = $res->data_seek($i);

                            $row = $res->fetch_assoc();
                        ?>
                        <tr data-id="row<?=$row['voucherId']?>" data-second-id="<?=$row['id']?>" id="row<?=$row['voucherId']?>">
                          <td data-field="id"><?=$row['voucherId']?></td>
                          <td data-field="user" ><?=$row['user']?></td>
                          <td data-field="name" ><?=$row['name']?></td>
                          <td data-field="lastName" ><?=$row['lastName']?></td>
                          <td data-field="email" ><?=$row['email']?></td>
                          <td data-field="telephone" ><?=$row['telephone']?></td>
                          <td style="text-align: center;">
                            <a href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?
  include("{$dir}modelPage/secondPart.php");
?>
