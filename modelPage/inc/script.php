<script src="<?=$dir_?>modelPage/js/jquery-3.3.1.min.js?v=<?=filemtime("{$dir}modelPage/js/jquery-3.3.1.min.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/jquery-ui.min.js?v=<?=filemtime("{$dir}modelPage/js/jquery-ui.min.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/popper.min.js?v=<?=filemtime("{$dir}modelPage/js/popper.min.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/bootstrap.min.js?v=<?=filemtime("{$dir}modelPage/js/bootstrap.min.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/jquery.tabledit.min.js?v=<?=filemtime("{$dir}modelPage/js/jquery.tabledit.min.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/all.js?v=<?=filemtime("{$dir}modelPage/js/all.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/datatables.min.js?v=<?=filemtime("{$dir}modelPage/js/datatables.min.js")?>"></script>

<script src="<?=$dir_?>modelPage/js/sb-admin-datatables.min.js?v=<?=filemtime("{$dir}modelPage/js/sb-admin-datatables.min.js")?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2/dist/bootstrap-confirmation.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

<script src="<?=$dir_?>modelPage/js/sb-admin.min.js?v=<?=filemtime("{$dir}modelPage/js/sb-admin.min.js")?>"></script>

<script>
  function widthFixed(){
      let tables = $('.dataTable');

      tables.each(function(i){
        let table = $(this), thead = table.find('thead'), ths = thead.find('th[scope=col]');

        ths.each(function(d){
          let th = $(this), widthTh = th.width();

          th.attr('style', "width:"+widthTh+"px!important");
        });
      });
  }

  function ajaxSelect(){
    let table = $('.dataTable'), arrayForTableedit = [], arrayTemp;

    table.find('thead').find('th').filter('[data-which]').not('[data-state=off]').each(function(i){
      let position = $(this).index(), which = $(this).attr('data-which'), where = $(this).attr('data-where'), type = $(this).is('[data-where]').toString();

      if(type!="true"){
        arrayTemp = [position, which];

        arrayForTableedit.push(arrayTemp);
      }
      else{
        let url = "", optionSelect;

        let dataAjax={
          "init" : "success",
          "dataWhere" : where
        };

        $.ajax({
          method: "POST",
          url: "<?=$dir_?>selectQuery.php",
          dataType: "json",
          data: dataAjax,
          async: false
        })
        .done(function(result){
          let arrayJSON = {}, arrayEditable = [];

          if(result.length!=0){
            result = result.data;

            if(where=="users"){
              arrayJSON.all = "Todos";
            }

            for(var i = 0; i < result.length; i++){
              arrayJSON[result[i].id] = result[i].name;
            }
          }

          optionSelect = JSON.stringify(arrayJSON);
        })
        .fail(function(){
        })
        .always(function(){
        });

        arrayTemp = [position, which, optionSelect];

        arrayForTableedit.push(arrayTemp);
      }
    });

    table.data('fieldsEditable', arrayForTableedit);
  }
  function popoverConfirmation(){
    $('[data-toggle=confirmation]').confirmation({
      rootSelector: '[data-toggle=confirmation]',
      onConfirm: function(){
        let id = $(this).closest('tr').attr('data-id');
        
        deleteQuick(id);
      }
    });

    dataTableEdit();
  }

  function generateAlert(class_, text){
    let putClass = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

    html = "";
    html += '<div class="'+putClass+' alert alert-'+class_+' animated bounceInLeft" role="alert">';
    html +=   text;
    html += '</div>';

    // return html;
    $('.breadcrumb').first().after(html);

    let elementAlert = $('.'+putClass);

    setTimeout(function(){
      elementAlert.removeClass('animated bounceInLeft');

      elementAlert.addClass('animated bounceOutLeft');

      elementAlert.bind('oanimationend animationend webkitAnimationEnd',function(){
        $(this).remove();
      });
    }, 4000);
  }

  function stateSelect(){
    if($('#userId').children().length==0){
      $('#userId').closest('.divSelect').css('display', 'none');

      $('.emptyUser').css('display', 'inline-flex');

      $('#iconLoading').removeAttr('style');
    }
    else{
      $('.emptyUser').css('display', 'none');

      $('#userId').closest('.divSelect').css('display', 'inline-flex');
    }
  }

  function deleteQuick(id=""){
    let view = $('#view').val(), tr = $('tr[data-id='+id+']');

    let url = '<?=$dir_?>deleteQuery.php';

    $.ajax({
      method: "POST",
      url: url,
      dataType: "json",
      data: { id: id, view: view },
    })
    .done(function(result) {
      let data = result.success;

      if(data == true){
        let dataTable = $('.dataTable').DataTable(), text;

        let trRow = "#row"+id, row = dataTable.row($(trRow));

        if(view=="users"){
          text = "El usuario fue eliminado con éxito.";
        }
        else if(view=="vouchers"){
          text = "Voucher eliminado con éxito.";
        }
        else if(view=="destinations"){
          text = "Destino eliminado con éxito.";
        }
        else{
          text = "Registro eliminado con éxito.";
        }

        if(tr.attr('data-second-id')!=undefined){
          let user = tr.find('td[data-field=name]').text();

          let lastName = tr.find('td[data-field=lastName]').text();

          let option = "<option value='"+tr.attr('data-second-id')+"'>"+user+" "+lastName+"</option>";

          $('.divSelect').find('select').append(option);

          stateSelect();
        }

        row.remove();

        $(trRow).remove();

        text!="" ? generateAlert("success", text) : null;
      }
      else if(data == false){
      }
    })
    .fail(function(fail){
      fail = fail.responseText;

      if(fail=="1451"){
        if(view=="users"){
          text = "El usuario está siendo utilizado, no es posible eliminarlo.";
        }
        else if(view=="vouchers"){
          text = "El voucher está siendo utilizado, no es posible eliminarlo.";
        }
        else if(view=="destinations"){
          text = "El destino está siendo utilizado, no es posible eliminarlo.";
        }
        else{
          text = "El registro está siendo utilizado, no es posible eliminarlo.";
        }

        text!="" ? generateAlert("danger", text) : null;
      }
    })
    .always(function(){
    });
  }

  function editTDHTML(field, name, value, type, options="", getEtiquette=""){
    let html = "";

    if(getEtiquette.length==0){
      let attributesTD = {};
    }

    if(type=="input" || type=="identifier"){
      let TDClass = type=="input" ? 'tabledit-view-mode' : 'sorting_1';

      let TDStyle = type=="input" ? 'cursor: pointer' : '';

      let classSpan = type=="input" ? 'tabledit-span' : 'tabledit-span tabledit-identifier';

      let classInput = type=="input" ? 'tabledit-input form-control input-sm' : 'tabledit-input tabledit-identifier';

      let typeInput = type=="input" ? 'text' : 'hidden';

      let styleInput = type=="input" ? 'display: none;' : '';

        if(getEtiquette.length==0){
          attributesTD = type=="input" ? {"data-field":field, "class":"tabledit-view-mode", "style":"cursor: pointer"} : {"data-field":field,"class":"sorting_1"};
        }
        else{
          html +='<td data-field="'+field+'" class="'+TDClass+'" style="'+TDStyle+'">';
        }
            html +='<span class="'+classSpan+'">'+name+'</span>';
            html +='<input class="'+classInput+'" type="'+typeInput+'" name="'+field+'" value="'+name+'" style="'+styleInput+'" disabled="">';
        if(getEtiquette.length>0){
          html +='</td>';
        }
    }
    else if(type=="disabled"){
      let TDClass = 'sorting_1';

      let TDStyle = '';

      let classSpan = 'tabledit-span tabledit-text';

      let classInput = 'tabledit-input tabledit-text';

      let typeInput = 'hidden';

      let styleInput = '';

        if(getEtiquette.length==0){
          attributesTD = {"data-field":field,"class":"sorting_1"};
        }
        else{
          html +='<td data-field="'+field+'" class="'+TDClass+'" style="'+TDStyle+'">';
        }
            html +='<span class="'+classSpan+'">'+name+'</span>';
            html +='<input class="'+classInput+'" type="'+typeInput+'" name="'+field+'" value="'+name+'" style="'+styleInput+'" disabled="">';
        if(getEtiquette.length>0){
          html +='</td>';
        }
    }
    else if(type=="select"){
      options = options;

      if(getEtiquette.length==0){
        attributesTD = {"data-field":field,"class":"tabledit-view-mode","style":"cursor: pointer; display: flex"};
      }
      else{
        html +='<td data-field="'+field+'" class="tabledit-view-mode" style="display: flex; cursor: pointer;">';
      }

      let optionsHTML = "", optionHTMLFirst = "";
      // html +='  <span class="tabledit-span">'+name+'</span>';
      html +='  <span class="tabledit-span">'+name+'</span>';
      html +='  <select class="tabledit-input form-control input-sm" name="'+field+'" style="display: none;" disabled="">';
                for (var i = 0; i < options.length; i++){
                  if(options[i].value=="all"){
                    optionHTMLFirst = '<option value="'+options[i].value+'"'+(options[i].value==value ? 'selected' : '')+'>'+options[i].name+'</option>';
                  }
                  else{
                    optionHTMLFirst = '<option value="all">Todos</option>';

                    optionsHTML +='<option value="'+options[i].value+'"'+(options[i].value==value ? 'selected' : '')+'>'+options[i].name+'</option>';
                  }
                }
      html += field != "stateId" ? optionHTMLFirst+optionsHTML : optionsHTML;
      html +='  </select>';

      if(getEtiquette.length>0){
        html +='</td>';
      }
    }

    if(getEtiquette.length==0){
      let parts = [];

      parts[0] = html;

      parts[1] = attributesTD;

      return parts;
    }
    else{
      return html;
    }
  }

  function PreviewImage($this){
    var oFReader = new FileReader();

    oFReader.readAsDataURL($this[0].files[0]);

    oFReader.onload = function(oFREvent){
      $this.closest('.rowOneFile').siblings('.rowTwoFile').find('#logoImage').attr('src', oFREvent.target.result);
    };
  }
  // function lastTD(where, data){
  //   let icons = "", state = "", tdLast = "";

  //   if(where=="vouchers" || where=="destinations"){
  //     state = "true";

  //     if(where=="vouchers"){
  //       icons+= '<div class="flexInit twoCenter">';
  //         icons+= '<i class="fas fa-user-plus"></i>';
  //       icons+= '</div>';

  //       icons+= '<div class="flexInit twoCenter">';
  //         icons+= '<i class="modalVarious fas fa-cloud-upload-alt"></i>';
  //       icons+= '</div>';
  //     }
  //     else if(where=="destinations"){
  //       icons+= '<div class="flexInit twoCenter">';
  //         icons+= '<i class="modalVarious fas fa-images"></i>';
  //       icons+= '</div>';
  //     }
  //   }

  //   if(state=="true"){
  //     tdLast+= '<div class="flexInit">';
  //       tdLast+= icons;

  //       tdLast+= '<div class="flexInit twoCenter">';
  //   }
  //         tdLast+= '<a style="display: flex" href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-id="'+(data.id.value)+'" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>';
  //   if(state=="true"){
  //       tdLast+= '</div>';
  //     tdLast+= '</div>';
  //   }

  //   return tdLast;
  // }

  function dataTableEdit(){
    if($('.dataTable').is('table')){
      $('.dataTable').Tabledit({
        url: '<?=$dir_?>editQuery.php',
        method: 'three',
        rowIdentifier: 'id',
        editButton: false,
        deleteButton: false,
        hideIdentifier: false,
        autoFocus: false,
        columns: {
            identifier: [0, 'id'],
            editable: $('.dataTable').data('fieldsEditable')
        },
        onSuccess: function(data){
          let id = data.id;

          delete data.id;

          delete data.success;

          data = data.data;

          let dataTable = $('.dataTable').DataTable(), trRow = "#row"+id, dataKeys = Object.keys(data), dataPosition;

          for(var i = 0; i < dataKeys.length; i++){
            dataPosition = data[dataKeys[i]];

            let options = dataPosition.options == undefined ? '' : dataPosition.options;

            // let addTD = editTDHTML(dataKeys[i], dataPosition.name, dataPosition.value, dataPosition.type, options, 'getEtiquette');
            let addTD = editTDHTML(dataKeys[i], dataPosition.name, dataPosition.value, dataPosition.type, options);

            let tdEdit = $(trRow).children("td[data-field='"+dataKeys[i]+"']");

            dataTable.cell( tdEdit ).data(dataPosition.name);

            tdEdit.html(addTD);
          }
        }
      });

      widthFixed();
    }
  }

  $(document).ready(function(){
    ajaxSelect();

    popoverConfirmation();

    stateSelect();

    let optionsDatePicker = {
      dateFormat: 'dd/mm/yy',
    	autoHide : 'true',
      };

    $('.table-responsive').on('click', '.modalUser', function(){
      let id = $(this).closest('tr').attr('data-id');

      $('#myModal .modal-title').text('Usuarios');

      $('#myModal .modal-body').html('<iframe src="<?=$dir_?>modelPage/modals/modalUser.php?id='+id+'" style="width:100%;height:500px" frameborder="0"></iframe>');
  
      $('#myModal').modal('show');
    });

    $('.table-responsive').on('click', '.modalImage', function(){
      let id = $(this).closest('tr').attr('data-id');

      $('#myModal .modal-title').html('Imagenes');

      $('#myModal .modal-body').html('<iframe src="<?=$dir_?>modelPage/modals/modalImage.php?id='+id+'" style="width:100%;height:500px" frameborder="0"></iframe>');
  
      $('#myModal').modal('show');
    });

    $('#since, #until').datepicker(optionsDatePicker);

    $('#addItem').on('click', function(){
      let _this = $(this);

      if($('.dataTable').is('table')){
        let form = $(".formValidate");

        let where = $("#view").val();

        if(form[0].checkValidity()===false){
          event.preventDefault();

          event.stopPropagation();

          form.addClass('was-validated');
        }
        else{
          let data_ = {}, name_ = $("input[name='name_']").val(), category_ = $("select[name='category_']").val(), type_;

          $("#iconLoading").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');

          $("#iconLoading").attr("style", "display: flex!important;");

          $.ajax({
            method: "GET",
            url: "<?=$dir_?>"+"/addQuery.php?"+$('.formValidate').serialize()+"&view="+where,
            dataType: "json",
            // data: data_
          })
          .done(function(result){
            let thsEnables, orderThs;

            thsEnables = $('.dataTable').find('thead').find('th').filter('[data-which]');

            orderThs = {};

            thsEnables.each(function(i){
              orderThs[$(this).attr('data-which')] = i;
            });

            if(result.success == true){
              let data = result.data, html = '<i class="fa fa-check" aria-hidden="true" style="color: #16a085"></i>', tdLast = "", icon = "";

              tdLast+= "<div class='flexInit'>";

              if($('.differentIcons')[0]!=undefined){
                tdLast+= $('.differentIcons')[0].outerHTML;
              }

              tdLast+= '<div class="flexInit twoCenter">';
                tdLast+= '<a style="display: flex" href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-id="'+(data.id.value)+'" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>';
              tdLast+= '</div>';

              tdLast+= '</div>';

              $("#iconLoading").html(html);

              let t = $('.dataTable').DataTable(), keys = Object.keys(data), arrayForRow = [], arrayForAttributesRow = [], dataOne;

              for(var i=0;i<keys.length;i++){
                dataOne = data[keys[i]];

                let options = dataOne.options == undefined ? '' : dataOne.options;

                if(where=="voucherUsers"){
                  type_ = "disabled";
                }
                else{
                  type_ = dataOne.type;
                }

                if(dataOne.type=="input" || dataOne.type=="identifier"){
                  if(orderThs[keys[i]]!=undefined){
                    let addTD = editTDHTML(keys[i], dataOne.name, dataOne.value, type_, options);

                    arrayForRow[orderThs[keys[i]]] = addTD[0];

                    arrayForAttributesRow[orderThs[keys[i]]] = addTD[1];
                  }
                }
                else if(dataOne.type=="select"){
                  if(orderThs[keys[i]]!=undefined){
                    let addTD = editTDHTML(keys[i], dataOne.name, dataOne.value, type_, options);

                    arrayForRow[orderThs[keys[i]]] = addTD[0];

                    arrayForAttributesRow[orderThs[keys[i]]] = addTD[1];
                  }
                }
                else if(dataOne.type=="text"){
                  if(orderThs[keys[i]]!=undefined){
                    arrayForRow[orderThs[keys[i]]] = dataOne.name;
                  }
                }

              }

              arrayForRow.push(tdLast);

              t.row.add(arrayForRow).draw( false );

              let etiquetteA = $('a[data-id='+(data.id.value)+']');

              let TDLastEdit = etiquetteA.parent();

              $(TDLastEdit).parent().attr('style', 'text-align: center');

              let TRParent = $(TDLastEdit).closest('tr');

              TRParent.find('td').each(function(i){
                if(arrayForAttributesRow[i]!=undefined){
                  let keysAttributes = Object.keys(arrayForAttributesRow[i]);

                  for (var d = 0; d < keysAttributes.length; d++){
                    attributeVal = arrayForAttributesRow[i][keysAttributes[d]];

                    $(this).attr(keysAttributes[d], attributeVal);
                  }
                }
              });

              TRParent.attr('id','row'+data.id.value);

              $('#statusMouseOver').val("true");

              $('.page-item').on('click', function(){
                $('#statusMouseOver').val("false");

                popoverConfirmation();
              });

              popoverConfirmation();

              optionSelect = $('.divSelect').find('select').find('option:selected');

              if(_this.attr('data-remove')=="true"){
                TRParent.attr('data-second-id', optionSelect.val());

                optionSelect.remove();

                stateSelect();
              }
            }
            else if (result.success == false){
              let html = '<i class="fa fa-times" aria-hidden="true" style="color: #ff5d5d;"></i>';

              $("#iconLoading").html(html);
            }
          })
          .fail(function(){
            console.log("error");
          })
          .always(function(){
            console.log("complete");
          });
        }
      }
    });

    $("th").on('click', function (){
      popoverConfirmation();
    });

    $('#dataTable_wrapper > div:nth-child(3) > div.col-sm-12.col-md-7').on('mouseover','#dataTable_paginate > ul',function(e){
      let statusMouseOver = $('#statusMouseOver').val();

      if(statusMouseOver=="false"){
        $('#statusMouseOver').val("true");

        $('.page-item').on('click', function(){
          $('#statusMouseOver').val("false");

          popoverConfirmation();
        });
      }
    });

    $("select[name='dataTable_length'], input[type='search']").on('change', function(){
      popoverConfirmation();
    });

    $('.logoFile').change(function(){
      let this_ = $(this);

      let progressImage = this_.closest('.rowOneFile').siblings('.rowTwoFile').find('#progressImage');

      progressImage.text("");

      progressImage.attr('aria-valuenow', "0");

      progressImage.attr('style', 'width: 0%');

      setTimeout(function(){
        let form = $('form')[0];

        let formData = new FormData(form);

        let url = "<?=$dir_?>getBase64.php";

        if(this_[0].files[0]!=undefined){
          let sizeFile = this_[0].files[0].size;

          if(sizeFile <= 1700000){
            PreviewImage(this_);

            formData.append('id', $('input[name=id]').val() );

            formData.append('where', $('input[name=where]').val() );

            formData.append('image', this_[0].files[0]);

            $.ajax({
              method: 'POST',
              url: url,
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function(result) {
                let result_base64 = result;

                let resultCheck = result.indexOf('base64');

                if(resultCheck!=-1){
                  $('.formValidate').append("<input type='hidden' name='image' value='"+result_base64+"' />");

                  let url = "<?=$dir_?>addQuery.php";

                  let formDate_ = new FormData();

                  formDate_.append('id', $('input[name=id]').val() );

                  formDate_.append('where', $('input[name=view]').val() );

                  formDate_.append('image', result_base64);

                  formDate_.append('position', this_.attr('position'));

                  $.ajax({
                    method: 'POST',
                    url: url,
                    data: formDate_,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result){
                      console.log("Ready");
                    }
                  });
                }
              },
              error: function(result) {
                console.log("error");
              },
              xhr: function(){
                  var xhr = new window.XMLHttpRequest();

                  xhr.upload.addEventListener("progress", function(e){

                    if (e.lengthComputable) {
                      percentComplete = parseInt( (e.loaded / e.total * 100), 10);

                      progressImage.text(percentComplete+"%");

                      progressImage.attr('aria-valuenow', percentComplete);

                      progressImage.attr('style', 'width: '+percentComplete+'%');
                    }
                    else{
                         console.log("Length not computable.");
                    }
                  }, false);
                  return xhr;
            }
            });
          }
          else{
            console.log("Supera el tamaño permitido");
          }
        }
        else{
          progressImage.text("");

          progressImage.attr('aria-valuenow', "0");

          progressImage.attr('style', 'width: 0%');
        }
        
      },1000);
    });

    $("#submitButtom").click(function(event) {
      let form = $(".formValidate");

      if (form[0].checkValidity() === false){
        event.preventDefault();

        event.stopPropagation();
      }

      form.addClass('was-validated');
    });

    var previousElem;

    $("input[type='radio']").click(function(e){
        var previous = $(this).attr('previous');

        if (previous == "true" && previousElem === this){
          $(this).prop('checked', false);
        }

        previousElem = this;

        $(this).attr('previous', $(this).prop('checked'));
    });
  });

  $(function(){
    $('textarea#description').summernote({
      placeholder: '',
      tabsize: 2,
      height: 290
    });
  });
</script>
