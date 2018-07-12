<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/settings/generalPanel.php");

include("{$dir}modelPage/inc/breadcrumb.php");

include("{$dir}modelPage/firstPart.php");

include("{$dir}settings/functions.php");

global $valueID;
global $row2;
$valueID = isset($_GET['id']) ? $_GET['id'] : '';

// var_dump($_GET['id']);die();

if(!empty($valueID))
{
  db_query(2, "select * from users where id='{$valueID}'");
}

function returnValue($column){
  global $valueID;
  global $row2;
  if(!empty($valueID))
  {
    if($column == "image")
    {
      $return = "/columbiaAPP/uploads/images/".$row2[$column];
    }
    else{
      $return = $row2[$column];
    }
    return $return;
  }
  else{
    return "";
  }
  // return '';
}

function selectOption($column, $i){
  global $valueID;
  global $row2;
  if(!empty($valueID))
  {
    if($column == $row2['idCompany'])
    {
      return 'selected';
    }
  }
  else{
    if($i == 0){
      return 'selected';
    }
  }
}
?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?
    include("{$dir}modelPage/parts/navbar.php");
  ?>
    <div class="container-fluid">
      <?
      $breadcrumb = empty($valueID) ? 'Agregar' : 'Editar';
      echo(breadcrumbName('Usuarios', $breadcrumb));
      ?>
        <form action="<?=$dir_?>variedQuery.php" class="formValidate needs-validation" method="post" novalidate>
        <input type="hidden" name="where" value="users"/>
        <?
        if(!empty($valueID))
        {
        ?>
          <input type="hidden" name="action" value="save"/>
          <input type="hidden" name="id" value="<?=returnValue('id')?>"/>
        <?
        }
        ?>
        <div class="row" style="padding-left: 10px; padding-right: 10px;">
          <div class="col-md-12">
            <hr>
          </div>
          <div class="col-md-4 mb-3">
            <label for="user">Usuario</label>
            <input type="text" class="form-control" name="user" value="<?=returnValue('user')?>" id="user" placeholder="" required>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-4 mb-3">
            <label for="password">Contraseña</label>
            <input type="password" name="password" value="<?=returnValue('password')?>" class="form-control" id="password" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?=returnValue('email')?>" id="email" placeholder="" required>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-6 mb-3">
            <label style="margin-right: 10px;" for="exampleFormControlSelect1">Empresa asociada</label>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio1" name="panel" value="user" class="custom-control-input" <?=returnValue('panel') == 'user' ? 'checked' : ''?>>
              <label class="custom-control-label" for="radio1">User</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="radio2" name="panel" value="adm" class="custom-control-input" <?=returnValue('panel') == 'adm' ? 'checked' : ''?>>
              <label class="custom-control-label" for="radio2">Admin</label>
            </div>
            <select class="form-control" name="idCompany" id="idCompany">
            <?
              db_query(0,'select * from companies where estado="1"');

              $i=0;

              while($i<$tot)
              {
                $nres = $res->data_seek($i);
                $row = $res->fetch_assoc();
                ?>
                <option <?=selectOption($row['id'], $i)?> value="<?=$row['id']?>"><?=$row['name']?></option>
                <?
                $i++;
              }
            ?>
            </select>
          </div>
          <div class="col-md-12">
            <hr style="margin-top: 0.1em!important">
          </div>
          <div class="col-md-4 mb-3">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" value="<?=returnValue('name')?>" id="name" placeholder="" required>
            <div class="valid-tooltip">
              ¡Perfecto!
            </div>
            <div class="invalid-tooltip">
              Por favor ingrese un valor.
            </div>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-4 mb-3">
            <label for="lastname">Apellido</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?=returnValue('lastname')?>" placeholder="" required>
            <div class="valid-tooltip">
              ¡Perfecto!
            </div>
            <div class="invalid-tooltip">
              Por favor ingrese un valor.
            </div>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-4 mb-3">
            <label for="telephone">Telefono</label>
            <input type="number" name="telephone" value="<?=returnValue('telephone')?>" class="form-control" id="telephone" placeholder="" required>
            <div class="valid-tooltip">
              ¡Perfecto!
            </div>
            <div class="invalid-tooltip">
              Por favor ingrese un valor.
            </div>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-6 mb-3">
            <label for="typeDocument">Tipo de documento</label>
            <select name="typeDocument" class="custom-select" size="3">
              <option value="dni" <?=returnValue('typeDocument') == 'dni' ? 'selected=""' : ''?>>D.N.I</option>
              <option value="pasaporte" <?=returnValue('typeDocument') == 'pasaporte' ? 'selected=""' : ''?>>Pasaporte</option>
            </select>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-6 mb-3" style="display: flex;flex: 1;flex-direction: column;justify-content: center;">
            <label for="nroDocument">Numero de documento</label>
            <input type="number" name="nroDocument" value="<?=returnValue('nroDocument')?>" class="form-control" id="nroDocument" placeholder="" required>
            <div class="valid-tooltip">
              ¡Perfecto!
            </div>
            <div class="invalid-tooltip">
              Por favor ingrese un valor.
            </div>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <div class="col-md-12 mb-3">
            <label for="centerCost">Central de costo</label>
            <input type="text" name="centerCost" value="<?=returnValue('centerCost')?>" class="form-control" id="centerCost" placeholder="" required>
            <div class="valid-tooltip">
              ¡Perfecto!
            </div>
            <div class="invalid-tooltip">
              Por favor ingrese un valor.
            </div>
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
          <?
          if(empty($valueID))
          {
          ?>
          <div class="col-md-12 mb-3">
            <div style="display: block">
              <label for="radios">Enviar email de bienvenida</label>
              <div id="radios">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="radio3" name="checkWelcome" value="true" class="custom-control-input" <?=returnValue('checkWelcome') == 'true' ? 'checked' : ''?>>
                  <label class="custom-control-label" for="radio3">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="radio4" name="checkWelcome" value="false" class="custom-control-input" <?=returnValue('checkWelcome') == 'false' ? 'checked' : ''?>>
                  <label class="custom-control-label" for="radio4">No</label>
                </div>
              </div>
            </div>
          </div>
          <?
          }
          ?>
          <div class="col-md-12 mb-3" style="margin-top: 10px;">
            <button id="submitButtom" type="submit" class="btn btn-primary"><?=empty($valueID) ? 'Agregar' : 'Guardar'?></button>
          </div>
        </div>
        </form>
    </div>
    <?
      include("{$dir}modelPage/secondPart.php");
    ?>
  </body>

  </html>
