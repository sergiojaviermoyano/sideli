<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Grupos</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadGrp(0,\'Add\')" id="btnAdd" >Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="groups" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th>Nombre</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>

  /*
  $(function () {
    //$("#groups").DataTable();
    $('#groups').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "language": {
              "lengthMenu": "Ver _MENU_ filas por página",
              "zeroRecords": "No hay registros",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "No hay registros disponibles",
              "infoFiltered": "(filtrando de un total de _MAX_ registros)",
              "sSearch": "Buscar:  ",
              "oPaginate": {
                  "sNext": "Sig.",
                  "sPrevious": "Ant."
                }
          }
      });
  });*/

  $(function () {

    var datatable_es={
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

    var dataTable= $('#order_table').DataTable({
      "processing": true,
      "serverSide": true,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "language":datatable_es,
      'ajax':{
          "dataType": 'json',
          //"contentType": "application/json; charset=utf-8",
          "method": "POST",
          "url":'index.php/order/listingOrders',
          "dataSrc": function (json) {
            var output=[];
            var permission=$("#permission").val();
            permission= permission.split('-');
            $.each(json.data,function(index,item){
              var td_1="";
                  td_1+='<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="Print('+item.ocId+')"></i>';

                  if(permission.indexOf("Edit")>0  && item.ocEstado=='AC'){
                    td_1+='<i  class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadOrder('+item.ocId+',\'Edit\')"></i>';
                  }

                  if(permission.indexOf("Del")>0){
                    td_1+='<i  class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadOrder('+item.ocId+',\'Del\')"></i>';
                  }

                  if(permission.indexOf("View")>0){
                    td_1+='<i  class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadOrder('+item.ocId+',\'View\')"></i>';
                  }

              var td_2="";
                 if(item.ocEsPresupuesto==1){
                   td_2+= '<small class="label pull-left bg-navy" style="font-size: 14px; margin-right: 5px;" title="Presupuesto">P</small>  &nbsp; &nbsp; ';
                 }
                 td_2+= item.ocObservacion;//item.ocObservacion;
              
              var date = new Date(item.ocFecha);
                        
              var month = date.getMonth() + 1;
              var td_3=("0"+date.getDate()).slice(-2)+'-'+("0"+ month).slice(-2)+'-'+("0"+date.getFullYear()).slice(-4)+' '+("0"+date.getHours()).slice(-2)+':'+("0"+date.getMinutes()).slice(-2);
              
              var td_4="";

              switch (item.ocEstado) {
                case 'AC':{
                  td_4='<small class="label pull-left bg-green">Activa</small>';
                  break;
                }
                case 'IN':{
                  td_4='<small class="label pull-left bg-red">Inactiva</small>';
                  break;
                }
                case 'FA':{
                  td_4='<small class="label pull-left bg-blue">Facturada</small>';
                  break;
                }
                default:{
                  td_4='';
                  break;
                }
              }
              //for(i=0;i<=100000;i++){
                output.push([td_1,td_2,td_3,td_4]);

              //}

            });
            return output;
          },
          error:function(the_error){
            console.debug(the_error);
          }
        }

    });
  });

  var idGrupo = 0;
  var acGrupo = '';

  function LoadGrp(id_, action){
  	idGrupo = id_;
  	acGrupo = action;
  	LoadIconAction('modalAction',action);
  	WaitingOpen('Cargando menu');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/group/getMenu', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyGrp").html(result.html);
			                setTimeout("$('#modalGrp').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalGrp');
    				},
          	dataType: 'json'
    		});
  }

  $('#btnSave').click(function(){
  	
  	if(acGrupo == 'View')
  	{
  		$('#modalGrp').modal('hide');
  		return;
  	}

  	var hayError = true;
  	var permission = [];
  	$('#permission :checked').each(function() {
        hayError = false;
        permission.push($(this).attr('id'));
    });

    if($('#grpName').val() == '')
    {
    	hayError = true;
    }

    if(hayError == true){
    	$('#errorGrp').fadeIn('slow');
    	return;
    }

    $('#errorGrp').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    	$.ajax({
          	type: 'POST',
          	data: { id : idGrupo, act: acGrupo, name: $('#grpName').val(), options: permission },
    		url: 'index.php/group/setMenu', 
    		success: function(result){
                			WaitingClose();
                			$('#modalGrp').modal('hide');
                			setTimeout("cargarView('group', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalGrp');
    				},
          	dataType: 'json'
    		});
  });
</script>


<!-- Modal -->
<div class="modal fade" id="modalGrp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Grupo</h4> 
      </div>
      <div class="modal-body" id="modalBodyGrp">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>