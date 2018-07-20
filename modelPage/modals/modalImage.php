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
              <h4 style="display: flex; align-items: center" class="title"><span style="padding-right: 5px">Agregar Imagenes</span><i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 20px; color: #16a085; margin-right: 4px;"></i></h4>
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
              }
            </style>
                
            <div class="content">
              <div class="divImagen">
                <div class="itemImagen">
                  <div class="rowOneFile">
                    <div class="col-md-12 mb-3" style="display: flex;justify-content: center;">
                      <div style="display: inline-block;">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen</label>
                        <input style="width: auto !important;" type="file" name="logox" class="form-control-file" id="logoFile" accept=".png,.jpg,.jpge,.gif">
                      </div>
                    </div>
                  </div>
                  <div class="rowTwoFile">
                    <img id="logoImage"style="max-height: 115px" class="img-fluid" src="">

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
