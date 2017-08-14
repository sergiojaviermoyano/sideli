<!-- Modal -->
<div class="modal fade" id="buscadorAgentes" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" ><!--style="width: 50%"-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-search" style="color: #3c8dbc"></i> Buscar <span id="titleType"></span></h4>
      </div>
      <div class="modal-body" id="buscadorAgenteBody">

        <div class="row">
          <div class="col-xs-10 col-xs-offset-1"><input type="text" class="form-control" id="txtAgente" value=""></div>
          <div class="col-xs-1"><img style="display: none" id="loadingAgente" src="<?php  echo base_url();?>assets/images/loading.gif" width="35px"></div>
            <!--
            <input type="text" id="type" />
            <span id="status"></span>
            -->
        </div><br>

        <div class="row" style="max-height:350px; overflow-x: auto;" id="tableAgente">
          <div class="col-xs-10 col-xs-offset-1">
            <table id="tableAgenteDetail" style="max-height:340px; display: table;" class="table table-bordered" width="100%">
              <tbody>

              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
var id_, detail_, nextFocus_, type_;
var timer, timeout = 1000;
var row = 0, rows = 0;
var move = 0;
var minLenght = -1;
function buscadorDeAgentes(string, id, detail, nextFocus, type){
  id_ = id;
  detail_ = detail;
  nextFocus_ = nextFocus;
  type_ = type;
  switch(type_){
    case 'E':
      $('#titleType').html('Emisor');
      break;

    case 'T':
      $('#titleType').html('Tenedor');
      break;
  }
  $('#txtAgente').val(string);
  $('#tableAgenteDetail > tbody').html('');
  $('#buscadorAgentes').modal('show');
  setTimeout(function () { $('#txtAgente').focus(); BuscarAgenteIn();}, 1000);
}

function BuscarAgenteIn(){
  if($('#txtAgente').val().length > minLenght){
    //Buscar 
    $("#loadingAgente").show();
    $('#tableAgenteDetail > tbody').html('');
    row = 0;
    rows = 0;
    $.ajax({
          type: 'POST',
          data: { 
                  code: $('#txtAgente').val(), 
                  type: type_ 
                },
          url: 'index.php/agent/buscadorDeAgentes',
          success: function(resultList){
                        if(resultList != false){
                          $.each(resultList, function(index, result){
                              var row_ = '<tr>';
                              row_ += '<td width="1%"><i style="color: #00a65a; cursor: pointer;" class="fa fa-fw fa-check-square"';
                              var string = '\''+result.apellido+' ,'+result.nombre + ( result.razon_social != '' ? '('+result.razon_social+')' : '')+'\'';
                              row_ += 'onClick="seleccionarAgente('+result.id+', '+string+', \''+result.cuit+'\')"></i></td>';
                              row_ += '<td>'+result.apellido+', '+result.nombre+' '+ ( result.razon_social != '' ? '('+result.razon_social+')' : '')+'</td>';
                              row_ += '<td>'+result.cuit+'</td>';
                              row_ += '<td style="display: none">'+result.id+'</td>';
                              row_ += '</tr>';
                              $('#tableAgenteDetail > tbody').prepend(row_);
                              rows++;
                          });
                          $('#txtAgente').focus();
                        }
                        $("#loadingAgente").hide();
                },
          error: function(result){
                $("#loadingAgente").hide();
                ProcesarError(result.responseText, 'buscadorAgentes');
              },
              dataType: 'json'
      });
  }
}

  $('#txtAgente').keyup(function(e){
    var code = e.which;
    if(code != 40 && code != 38 && code != 13){
      if($('#txtAgente').val().length >= minLenght){
        // Clear timer if it's set.
        if (typeof timer != undefined)
          clearTimeout(timer);

        // Set status to show we're typing.
        //$("#status").html("Typing ...").css("color", "#009900");
        
        
        timer = setTimeout(function()
        {
          //$("#status").html("Stopped").css("color", "#990000");
          $("#loadingAgente").show();
          BuscarAgenteIn();
          row = 0;
        }, timeout);
      }
    } else {
      var removeStyle = $("#tableAgenteDetail > tbody tr:nth-child("+row+")");
      if(code == 13){//Seleccionado
        removeStyle.css('background-color', 'white');
        seleccionarAgente(
                          $('#tableAgenteDetail tbody tr:nth-child('+row+') td:nth-child(4)')[0].innerHTML,
                          $('#tableAgenteDetail tbody tr:nth-child('+row+') td:nth-child(2)')[0].innerHTML,
                          $('#tableAgenteDetail tbody tr:nth-child('+row+') td:nth-child(3)')[0].innerHTML
                        );
      }

      if(code == 40){//abajo
        if((row + 1) <= rows){
          row++;
          if(row > 5){
          }
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableAgenteDetail > tbody tr:nth-child("+row+")");
        rowE.css('background-color', '#D8D8D8');
        animate();
      } 
      if(code == 38) {//arriba
        if(row >= 2){
          row--;
          removeStyle.css('background-color', 'white');
        }
        var rowE = $("#tableAgenteDetail > tbody tr:nth-child("+row+")");
        rowE.css('background-color', '#D8D8D8');
        animate();
      }
    }
  });

function seleccionarAgente(id, detail, cuit){
    id_.val(id);
    detail_.val(detail + '  CUIT:' + cuit);
    $('#buscadorAgentes').modal('hide');
    setTimeout(function () { nextFocus_.focus(); }, 800);
}

</script>