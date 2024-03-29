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
      <input type="hidden" id="view" name="view" value="destinations"/>
      <!-- <input type="hidden" name="statusInit" id="statusInit" value="false"/> -->
      <input type="hidden" name="statusMouseOver" id="statusMouseOver" value="false"/>
      <?
      echo(breadcrumbName('Destinos','Listado'));
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> Destinos </div>
            <div class="card-body row">
              <div class="col-lg-8">
                <div class="table-responsive">
                <table class="table table-bordered" data-view="destinations" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th scope="col" data-which="id" data-state="off">ID</th>
                      <th scope="col" data-which="title">Titulo</th>
                      <th scope="col" data-which="subtitle">Subtitulo</th>
                      <th scope="col" data-which="description">Descripcion</th>
                      <th scope="col" data-which="stateId" data-where="states">Estado</th>
                      <th scope="col" data-which="dateCreated" data-state="off">Fecha de creación</th>
                      <th scope="col"><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Titulo</th>
                      <th>Subtitulo</th>
                      <th>Descripcion</th>
                      <th>Estado</th>
                      <th>Fecha de creación</th>
                      <th><div style="display: block; width: 60px; height: 2px"></div></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?
                      db_query(0,'select destinations.*, states.id as stateId, states.name as stateName from destinations join states on destinations.stateId = states.id');
                      $i=0;
                      while($i<$tot)
                      {
                        $nres = $res->data_seek($i);
                        $row = $res->fetch_assoc();
                    ?>
                    <tr data-id="row<?=$row['id']?>" id="row<?=$row['id']?>">
                      <td data-field="id" ><?=$row['id']?></td>
                      <td data-field="title" ><?=$row['title']?></td>
                      <td data-field="subtitle" ><?=$row['subtitle']?></td>
                      <td data-field="description" ><?=$row['description']?></td>
                      <td data-field="stateId" ><?=$row['stateName']?></td>
                      <td data-field="dateCreated" ><?=$row['dateCreated']?></td>
                      <td style="text-align: center;">
                        <!-- <a style="padding-right: 15px;" href="<?=$dir_?>categories/add.php?id=<?=$row['idCat']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
                        <div class="flexInit">
                          <div class="differentIcons">
                            <div class="flexInit twoCenter">
                              <i class="modalImage modalVarious far fa-images"></i>
                            </div>
                          </div>

                          <div class="flexInit twoCenter">
                            <a style="display: flex" href="#" data-toggle="confirmation" data-popout="true" data-btn-ok-label="Si" data-id="<?=$row['id']?>" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>
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
                    <div class="row styleRow">
                      <label for="title">Titulo</label>

                      <input type="text" class="form-control" name="title" value="" id="title" placeholder="" required="">

                      <!-- <small id="title" class="form-text text-muted">Escribe el titulo del destino</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="subtitle">Subtitulo</label>

                      <input type="text" class="form-control" name="subtitle" value="" id="subtitle" placeholder="" required="">
                      
                      <!-- <small id="subtitle" class="form-text text-muted">Escribe el titulo del destino</small> -->
                    </div>

                    <div class="row styleRow">
                      <label for="description">Descripcion</label>

                      <input type="text" class="form-control" name="description" value="" id="description" placeholder="" required="">
                      
                      <!-- <small id="description" class="form-text text-muted">Escribe el titulo del destino</small> -->
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

                  <div class="row styleRow" style="padding: 20px!important">
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
