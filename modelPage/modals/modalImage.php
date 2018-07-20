<?
error_reporting(E_ALL);

ini_set('display_errors', '1');

include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/generalPanel.php");

include("{$dir}modelPage/inc/breadcrumb.php");

include("{$dir}modelPage/firstPart.php");

db_query(0,"select * from destinations where id=".$_GET['id']);
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

    <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>

    <input type="hidden" id="view" name="view" value="voucherUsers"/>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="padding-top: 5px;">
          <div class="card">
            <div class="header">
              <h4 style="display: flex; align-items: center" class="title">Agregar Imagenes</h4>
            </div>

            <style>
              .divImagen{
                display:flex;
                width:auto;
                height:auto;
                flex-direction: row; 
                justify-content: space-between;
                align-items: center; 
                flex-wrap: wrap
              }

              .itemImagen{
                display: flex;
                flex-direction: column; 
                padding: 15px;
                max-width: 420px;
              }
            </style>
                
            <div class="content">
              <div class="divImagen"> <!--  --> 
                <div class="itemImagen"> <!--  -->
                  <div class="rowOneFile">
                    <div class="col-md-12 mb-3" style="display: flex;justify-content: center;">
                      <div style="display: inline-block;" class="logo">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen 1</label>

                        <input type="file" name="logo_1" position="1" class="form-control-file logoFile" accept=".png, .jpg, .jpge, .gif">
                      </div>
                    </div>
                  </div>
                  <div class="rowTwoFile">
                    <img id="logoImage"style="max-height: 115px" class="img-fluid" src="<?=!empty($row['image1']) ? $dir_."uploads/images/".$row['image1'] : ""?>">

                    <div class="progress" style="margin-top: 5px;width: 100%;">
                      <div id="progressImage" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>

                <div class="itemImagen"> <!--  -->
                  <div class="rowOneFile">
                    <div class="col-md-12 mb-3" style="display: flex;justify-content: center;">
                      <div style="display: inline-block;" class="logo">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen 2</label>

                        <input type="file" name="logo_2" position="2" class="form-control-file logoFile" accept=".png, .jpg, .jpge, .gif">
                      </div>
                    </div>
                  </div>
                  <div class="rowTwoFile">
                    <img id="logoImage"style="max-height: 115px" class="img-fluid" src="<?=!empty($row['image2']) ? $dir_."uploads/images/".$row['image2'] : ""?>">

                    <div class="progress" style="margin-top: 5px;width: 100%;">
                      <div id="progressImage" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>

                <div class="itemImagen"> <!--  -->
                  <div class="rowOneFile">
                    <div class="col-md-12 mb-3" style="display: flex;justify-content: center;">
                      <div style="display: inline-block;" class="logo">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen 3</label>

                        <input type="file" name="logo_3" position="3" class="form-control-file logoFile" accept=".png, .jpg, .jpge, .gif">
                      </div>
                    </div>
                  </div>
                  <div class="rowTwoFile">
                    <img id="logoImage"style="max-height: 115px" class="img-fluid" src="<?=!empty($row['image3']) ? $dir_."uploads/images/".$row['image3'] : ""?>">

                    <div class="progress" style="margin-top: 5px;width: 100%;">
                      <div id="progressImage" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>

                <div class="itemImagen"> <!--  -->
                  <div class="rowOneFile">
                    <div class="col-md-12 mb-3" style="display: flex;justify-content: center;">
                      <div style="display: inline-block;" class="logo">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen 4</label>

                        <input type="file" name="logo_4" position="4" class="form-control-file logoFile" accept=".png, .jpg, .jpge, .gif">
                      </div>
                    </div>
                  </div>
                  <div class="rowTwoFile">
                    <img id="logoImage"style="max-height: 115px" class="img-fluid" src="<?=!empty($row['image4']) ? $dir_."uploads/images/".$row['image4'] : ""?>">

                    <div class="progress" style="margin-top: 5px;width: 100%;">
                      <div id="progressImage" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>

                <div class="itemImagen"> <!--  -->
                  <div class="rowOneFile">
                    <div class="col-md-12 mb-3" style="display: flex;justify-content: center;">
                      <div style="display: inline-block;" class="logo">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen 5</label>

                        <input type="file" name="logo_5" position="5" class="form-control-file logoFile" accept=".png, .jpg, .jpge, .gif">
                      </div>
                    </div>
                  </div>
                  <div class="rowTwoFile">
                    <img id="logoImage"style="max-height: 115px" class="img-fluid" src="<?=!empty($row['image5']) ? $dir_."uploads/images/".$row['image5'] : ""?>">

                    <div class="progress" style="margin-top: 5px;width: 100%;">
                      <div id="progressImage" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
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
