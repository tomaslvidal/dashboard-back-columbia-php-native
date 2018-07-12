<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/generalPanel.php");

include("{$dir}modelPage/inc/breadcrumb.php");

include("{$dir}modelPage/firstPart.php");
?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?
    include("{$dir}modelPage/parts/navbar.php");
  ?>
    <div class="container-fluid">
      <input type="hidden" id="view" name="view" value="users"/>
      <?
      echo(breadcrumbName('Usuarios', 'Listado'));
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> Usuarios </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Usuario</th>
                      <th>Panel</th>
                      <th>Empresa</th>
                      <th>Email</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Telefono</th>
                      <th>Tipo de documento</th>
                      <th>Numero de documento</th>
                      <th>Centro de costo</th>
                      <th>Fecha de registro</th>
                      <th>Fecha de modificación</th>
                      <th><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Usuario</th>
                      <th>Panel</th>
                      <th>Empresa</th>
                      <th>Email</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Telefono</th>
                      <th>Tipo de documento</th>
                      <th>Numero de documento</th>
                      <th>Centro de costo</th>
                      <th>Fecha de registro</th>
                      <th>Fecha de modificacion</th>
                      <th><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?
                      db_query(0,'select * from users where estado="1"');
                      $i=0;
                      while($i<$tot)
                      {
                        $nres = $res->data_seek($i);
                        $row = $res->fetch_assoc();

                    ?>
                    <tr id="row<?=$row['id']?>">
                      <td><?=$row['user']?></td>
                      <td><?=$row['panel']=="adm" ? 'admin' : $row['panel']?></td>
                      <td>
                      <?
                      $id = $row['idCompany'];
                      db_query(1, "select * from companies where id='{$id}'");
                      echo $row1['name'];
                      ?>
                      </td>
                      <td><?=$row['email']?></td>
                      <td><?=$row['name']?></td>
                      <td><?=$row['lastname']?></td>
                      <td><?=$row['telephone']?></td>
                      <td><?=$row['typeDocument']?></td>
                      <td><?=$row['nroDocument']?></td>
                      <td><?=$row['centerCost']?></td>
                      <td><?=date('d/m/Y',strtotime($row['fechaRegistro']))?></td>
                      <td>
                      <?
                        $fecha = date('d/m/Y',strtotime($row['fechaModificacion']));
                        if($fecha != '31/12/1969')
                        {
                          printf($fecha);
                        }
                      ?>
                      </td>
                      <td style="text-align: center;">
                        <a style="padding-right: 15px;" href="<?=$dir_?>users/add.php?id=<?=$row['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
            <div class="card-footer small text-muted"></div>
          </div>
        </div>
      </div>
    </div>
    <?
      include("{$dir}modelPage/secondPart.php");
    ?>
  </body>

  </html>
