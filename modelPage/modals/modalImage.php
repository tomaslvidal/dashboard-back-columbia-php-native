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

    <input type="hidden" id="view" name="view" value="destinationsImage"/>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="padding-top: 5px;">
          <div class="card modalImage">
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

              .divClose{
                display: flex; 
                justify-content: flex-end;
              }

              .iconClose{
                color: black;
                cursor: pointer;
              }

              .logoImagen{
                max-height: 115px;
              }

              .progress{
                margin-top: 5px;
                margin-left: 5px;
                width: 100%;
              }

              #progressImage{
                width: 0%;
              }

              .divGeneralUpload{
                display: flex; 
                flex-direction: column
              }

              .divLabelInput{
                display: flex;
                justify-content: center;
              }
            </style>
            <div class="content">
              <div class="divImagen"> <!--  --> 

                <?
                for ($i=1; $i <= 5; $i++){ 
                ?>
                <div class="itemImagen"> <!--  -->
                  <div class="rowOneFile">
                    <div class="divLabelInput col-md-12 mb-3">
                      <div style="display: inline-block;" class="logo">
                        <label style="margin-bottom: .7rem;" for="logoFile">Imagen <?=$i?></label>

                        <input type="file" data-position="<?=$i?>" name="logo_<?=$i?>" position="<?=$i?>" class="form-control-file logoFile" accept=".png, .jpg, .jpge, .gif">
                      </div>
                    </div>
                  </div>
                  <div class="divGeneralUpload">
                    <?
                    if(!empty($row['image'.$i])){
                    ?>
                      <div class="divClose">
                        <i class="iconClose fas fa-window-close"></i>
                      </div>
                    <?
                    }
                    ?>
                    <div class="rowTwoFile">
                      <img id="logoImage" class="img-fluid" src="<?=!empty($row['image'.$i]) ? $dir_."uploads/images/".$row['image'.$i] : ""?>">

                      <div class="progress">
                        <div id="progressImage" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?
  include("{$dir}modelPage/secondPart.php");
?>
<script>
$(document).ready(function(){
  $('.modalImage').on('click', '.iconClose', function(){
    let r = confirm("¿Esta seguro que desea eliminar la imagen?");

    let name_ = $(this).closest('.divGeneralUpload').siblings('.rowOneFile').find('input').attr('data-position');

    let this_ = $(this);

    if(r){
      $.ajax({
        type: 'POST',
        url: "<?=$dir_?>deleteQuery.php",
        data: {"view": $('input[name=view]').val(), "id": $('input[name=id]').val(), "name" : name_},
        success: function(){
          let divGeneralUpload = this_.closest('.divGeneralUpload');

          divGeneralUpload.find('.rowTwoFile').find('img').attr('src', '');

          this_.closest('.divClose').remove();

          let progressImage = divGeneralUpload.find('#progressImage');

          progressImage.text("");

          progressImage.attr('aria-valuenow', "0");

          progressImage.attr('style', 'width: 0%');
        }
      });
    }
    else{
      return false;
    }
  });
});
</script>