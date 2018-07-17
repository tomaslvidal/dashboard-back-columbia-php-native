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
        let id = $(this)[0].getAttribute('data-id');
        
        deleteQuick(id);
      }
    });

    dataTableEdit();
  }

  function deleteQuick(id=""){
    let view = $('#view').val();

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
        let dataTable = $('.dataTable').DataTable();

        let trRow = "#row"+id, row = dataTable.row($(trRow));

        row.remove();

        $(trRow).remove();
      }
      else if(data == false){
      }
    })
    .fail(function(fail){
      fail = fail.responseText;
      
      console.log("fail: ", fail);
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
    else if(type=="select"){
      options = options;

      if(getEtiquette.length==0){
        attributesTD = {"data-field":field,"class":"tabledit-view-mode","style":"cursor: pointer"};
      }
      else{
        html +='<td data-field="'+field+'" class="tabledit-view-mode" style="cursor: pointer;">';
      }

      html +='  <span class="tabledit-span">'+name+'</span>';
      html +='  <select class="tabledit-input form-control input-sm" name="'+field+'" style="display: none;" disabled="">';
                for (var i = 0; i < options.length; i++)
                {
                  html +='<option value="'+options[i].value+'"'+(options[i].value==value ? 'selected' : '')+'>'+options[i].name+'</option>';
                }
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

  function PreviewImage(){
    var oFReader = new FileReader();

    oFReader.readAsDataURL(document.getElementById("logoFile").files[0]);

    oFReader.onload = function(oFREvent){
        document.getElementById("logoImage").src = oFREvent.target.result;
    };
  }

  function dataTableEdit(){
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

  $(document).ready(function(){
    ajaxSelect();

    popoverConfirmation();

    let optionsDatePicker = {
      dateFormat: 'dd/mm/yy',
    	autoHide : 'true',
      };

    $('#since, #until').datepicker(optionsDatePicker);

    $('#addItem').on('click', function(){
      let form = $(".formValidate");

      let where = $("#view").val();

      if(form[0].checkValidity()===false){
        event.preventDefault();

        event.stopPropagation();

        form.addClass('was-validated');
      }
      else{
        let data_= {}, name_ = $("input[name='name_']").val(), category_ = $("select[name='category_']").val();

        $("#iconLoading").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');

        $("#iconLoading").attr("style", "display: flex!important;");

        $.ajax({
          method: "GET",
          url: "<?=$dir_?>"+"/addQuery.php?"+$('.formValidate').serialize()+"&view="+$('#view').val(),
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
            let data = result.data, html = '<i class="fa fa-check" aria-hidden="true" style="color: #16a085"></i>', tdLast = "";

            tdLast+= '<div class="nonec" id="i-'+(data.id.value)+'"></div>';

            tdLast+= '<a href="#" data-toggle="confirmation" data-btn-ok-label="Si" data-id="'+(data.id.value)+'" data-btn-cancel-label="No" data-title="¿Está seguro?"><i class="buttonDelete fa fa-trash" aria-hidden="true"></i></a>';

            $("#iconLoading").html(html);

            let t = $('.dataTable').DataTable(), keys = Object.keys(data), arrayForRow = [], arrayForAttributesRow = [], dataOne;

            for(var i=0;i<keys.length;i++){
              dataOne = data[keys[i]];

              let options = dataOne.options == undefined ? '' : dataOne.options;

              if(dataOne.type=="input" || dataOne.type=="identifier"){
                if(orderThs[keys[i]]!=undefined){
                  let addTD = editTDHTML(keys[i], dataOne.name, dataOne.value, dataOne.type, options);

                  arrayForRow[orderThs[keys[i]]] = addTD[0];

                  arrayForAttributesRow[orderThs[keys[i]]] = addTD[1];
                }
              }
              else if(dataOne.type=="select"){
                if(orderThs[keys[i]]!=undefined){
                  let addTD = editTDHTML(keys[i], dataOne.name, dataOne.value, dataOne.type, options);

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

            let TDLastEdit = '#i-'+data.id.value;

            $(TDLastEdit).parent().attr('style', 'text-align: center');

            let TRParent = $(TDLastEdit).parent().parent();

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

            // $("#statusInit").val("true");
            $('#statusMouseOver').val("true");

            $('.page-item').on('click', function(){
              $('#statusMouseOver').val("false");

              popoverConfirmation();
            });

            popoverConfirmation();
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

    $('#logoFile').change(function(){
      $('#progressImage').text("");

      $('#progressImage').attr('aria-valuenow', 0);

      $('#progressImage').attr('style', 'width: '+"0"+'%');

      setTimeout(function(){
        let form = $('form')[0];

        let formData = new FormData(form);

        let url = '<?=$dir_?>uploadFile.php';

        let sizeFile = $('input[type=file]')[0].files[0].size;

        if(sizeFile<=1700000)
        {
          PreviewImage();

          formData.append('id', $('input[name=id]').val());

          formData.append('where', $('input[name=where]').val());

          formData.append('image', $('input[type=file]')[0].files[0]);

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

              if(resultCheck!=-1)
              {
                $('.formValidate').append("<input type='hidden' name='image' value='"+result_base64+"' />");
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

                    $('#progressImage').text(percentComplete+"%");

                    $('#progressImage').attr('aria-valuenow', percentComplete);

                    $('#progressImage').attr('style', 'width: '+percentComplete+'%');
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
      },1000);
    });

    $("#submitButtom").click(function(event) {
      let form = $(".formValidate");

      if (form[0].checkValidity() === false) {
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
