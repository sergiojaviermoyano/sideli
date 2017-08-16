<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
           
          <h3 class="box-title"><?php echo ($type=='1')?'Emisores':'Tenedores';?> </h3>
          <input type="hidden" name="agent_type" id="agent_type" value="<?php echo $type;?>">
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success btn-flat" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadEmi(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="agentes_table" class="table table-bordered table-hover dataTable">
            <thead>
              <tr>                
                <th>Nombre y Apellido</th>
                <th>Cuit</th>
                <th>Estado</th>
                <th width="20%">Acciones</th>
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


<!-- Modal -->
<div class="modal fade" id="modalEmisor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> <?php echo ($type=='1')?'Emisor':'Tenedor';?></h4>
      </div>
      <div class="modal-body form-horizontal" id="modalBodyEmisor" >

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>

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

    var dataTable= $('#agentes_table').DataTable({
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
          "method": "POST",
          "url":'index.php/agent/listingAgent/'+$("#agent_type").val(),
          "dataSrc": function (json) {
            var output=[];
            var permission=$("#permission").val();
            permission= permission.split('-');
            $.each(json.data,function(index,item){        
              
              var td_2=item.nombre + ' ' +item.apellido;
              var td_3=item.cuit;


              var td_4=item.estado ;

              var td_1="";
              if(permission.indexOf("Edit")>0  ){
                td_1+='<i  class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadEmi('+item.id+',\'Edit\')"></i>';
              }

              if(permission.indexOf("Del")>0){
                td_1+='<i  class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadEmi('+item.id+',\'Del\')"></i>';
              }

              if(permission.indexOf("View")>0){
                td_1+='<i  class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadEmi('+item.id+',\'View\')"></i>';
              }
              
              output.push([td_2,td_3,td_4,td_1]);

            });
            return output;
          },
          error:function(the_error){
            console.debug(the_error);
          }
        }

    });
  });

  
  var idEmisor = 0;
  var acEmisor = '';
  
  function LoadEmi(id_, action){
  	idEmisor = id_;
  	acEmisor = action;
    console.debug(" => id_: %o",id_);
    console.debug(" => action: %o",action);
    
  	LoadIconAction('modalAction',action);
  	WaitingOpen('Cargando Emisores');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/agent/getAgente/'+$("#agent_type").val(), 
    		success: function(result){
          //console.debug(" => result: %o",result);
			                WaitingClose();
			                $("#modalBodyEmisor").html(result.html);
                       $("#AgenteCuit").inputmask("99-99999999-9",{ "clearIncomplete": true });
			                setTimeout("$('#modalEmisor').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalEmisor');
    				},
          	dataType: 'json'
    		}); 
  }

  
  $('#btnSave').on('click',function(){
  	console.debug("===> TES");
  	if(acEmisor == 'View')
  	{
  		$('#modalEmisor').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#AgenteNombre').val() == '')
    {
    	hayError = true;
    }

    if($('#AgenteApellido').val() == '')
    {
      hayError = true;
    }

    if($('#AgenteCuit').val() == '')
    {
      hayError = true;
    }

    if(hayError == true){
    	$('#error').fadeIn('slow');
    	return;
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    $.ajax({
      type: 'POST',
      data: { 
        act: acEmisor, 
        id: $('#AgenteId').val(),        
        nombre: $('#AgenteNombre').val(),
        apellido: $('#AgenteApellido').val(),
        cuit: $('#AgenteCuit').val(),
        razon_social: $('#AgenteRazonSocial').val(),
        domicilio: $('#AgenteDomicilio').val(),
        telefono: $('#AgenteTelefono').val(),
        celular: $('#AgenteCelular').val(),
        email: $('#AgenteEmail').val(),        
        tipo: $('#AgenteTipo').val()
      },
      url: 'index.php/agent/setAgente', 
      success: function(result){
        WaitingClose();
        $('#modalEmisor').modal('hide');
        if($("#agent_type").val()==1){
          setTimeout("cargarView('agent', 'emisor_list', '"+$('#permission').val()+"');",1000);
        }else if($("#agent_type").val()==2){
          setTimeout("cargarView('agent', 'tenedor_list', '"+$('#permission').val()+"');",1000);
        }else{
          setTimeout("cargarView('agent', 'emisor_list', '"+$('#permission').val()+"');",1000);
        }
        
      },
      error: function(result){
        WaitingClose();
        alert("error");
      },
      dataType: 'json'
      });
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalEmisor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Usuario</h4> 
      </div>
      <div class="modal-body" id="modalBodyEmisor">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>