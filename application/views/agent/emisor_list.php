<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Emisores</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success btn-flat" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadEmi(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="emisores" class="table table-bordered table-hover dataTable">
            <thead>
              <tr>
                
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Domicílio</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Estado</th>
                <th>Ingresado</th>
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
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Emisor</h4>
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
    /*
  $(function () {
    $('#users').DataTable({
            "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "language": {
            "lengthMenu": "Ver _MENU_ filas por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
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

    var dataTable= $('#emisores').DataTable({
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
          "url":'index.php/agent/listingEmisores',
          "dataSrc": function (json) {
            console.debug("==> resultado: %o",json);
            var output=[];
            var permission=$("#permission").val();
            permission= permission.split('-');
            $.each(json.data,function(index,item){
              console.debug("==> permission: %o:",permission);
              console.debug("==> permission: %o",permission.indexOf("Edit"));
              console.debug("==> emisor: %o - %o:",index,item);
              
              
              var td_2=item.nombre;
              var td_3=item.apellido;
              var td_4=item.domicilio;
              var td_5=item.telefono ;
              var td_6=item.celular;
              var td_7="";
              var td_8=item.created;

              var td_1="";
                 // td_1+='<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="Print('+item.id+')"></i>';

                  if(permission.indexOf("Edit")>0  ){
                    td_1+='<i  class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadEmi('+item.id+',\'Edit\')"></i>';
                  }

                  if(permission.indexOf("Del")>0){
                    td_1+='<i  class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadEmi('+item.id+',\'Del\')"></i>';
                  }

                  if(permission.indexOf("View")>0){
                    td_1+='<i  class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadEmi('+item.id+',\'View\')"></i>';
                  }
              //for(i=0;i<=100000;i++){
                output.push([td_2,td_3,td_4,td_5,td_6,td_7,td_8,td_1]);

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

  
  var idEmisor = 0;
  var acEmisor = '';
  
  function LoadEmi(id_, action){
  	idEmisor = id_;
  	acEmisor = action;
  	LoadIconAction('modalAction',action);
  	WaitingOpen('Cargando Emisores');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/agent/getEmisor', 
    		success: function(result){
          console.debug(" => result: %o",result);
			                WaitingClose();
			                $("#modalBodyEmisor").html(result.html);
			                setTimeout("$('#modalEmisor').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					alert("error");
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
    if($('#EmisorNombre').val() == '')
    {
    	hayError = true;
    }

    if($('#EmisorApellido').val() == '')
    {
      hayError = true;
    }

    if($('#EmisorCuit').val() == '')
    {
      hayError = true;
    }
    /*
    if($('#EmisorRazonSocial').val() == '')
    {
      hayError = true;
    }
    if($('#EmisorDomicilio').val() == '')
    {
      hayError = true;
    }
    if($('#EmisorTelefono').val() == '')
    {
      hayError = true;
    }
    if($('#EmisorCelular').val() == '')
    {
      hayError = true;
    }
    if($('#EmisorEmail').val() == '')
    {
      hayError = true;
    }
    */


    /*if($('#EmisorPassword').val() != $('#EmisorPasswordConf').val()){
      hayError = true;
    }*/
    console.debug("===> hayError: %o",hayError);
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
        id: $('#EmisorId').val(),        
        nombre: $('#EmisorNombre').val(),
        apellido: $('#EmisorApellido').val(),
        cuit: $('#EmisorCuit').val(),
        razon_social: $('#EmisorRazonSocial').val(),
        domicilio: $('#EmisorDomicilio').val(),
        telefono: $('#EmisorTelefono').val(),
        celular: $('#EmisorCelular').val(),
        email: $('#EmisorEmail').val(),        
        tipo: $('#EmisorTipo').val()
      },
      url: 'index.php/agent/setEmisor', 
      success: function(result){
        WaitingClose();
        $('#modalEmisor').modal('hide');
        setTimeout("cargarView('user', 'index', '"+$('#permission').val()+"');",1000);
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