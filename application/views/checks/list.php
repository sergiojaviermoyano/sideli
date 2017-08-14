<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Cheques</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadCheque(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="checks" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Número</th>
                <th>Banco</th>
                <th>Emisor</th>
                <th>Importe</th>
                <th>Vencimiento</th>
                <th>Estado</th>
                <th width="10%">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                /*
                if(isset($list)){
                  if($list != false)
                	foreach($list as $c)
      		        {
  	                echo '<tr>';                  
                    echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
                        echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadCheque('.$c['id'].',\'Edit\')"></i>';
                    }
  	                if (strpos($permission,'Del') !== false) {
                        echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadCheque('.$c['id'].',\'Del\')"></i>';
                    }
                    if (strpos($permission,'View') !== false) {
                        echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadCheque('.$c['id'].',\'View\')"></i> ';
                    }
  	                		
  	                echo '</td>';
  	                echo '<td style="text-align: right">'.$c['numero'].'</td>';
                    echo '<td style="text-align: left">'.$c['rsbco'].' Suc:'.$c['sucursal'].'</td>';
                    echo '<td style="text-align: left">'.$c['apellido'].', '.$c['nombre'].' '.( $c['rsag'] != '' ? '('.$c['rsag'].')' : '').'</td>';
                    echo '<td style="text-align: right">'.$c['importe'].'</td>';
                    $c['vencimiento'] = explode('-',$c['vencimiento']);
                    echo '<td style="text-align: center">'.$c['vencimiento'][2].'-'.$c['vencimiento'][1].'-'.$c['vencimiento'][0].'</td>';
                    echo '<td style="text-align: center">'. .'</td>';
  	                echo '</tr>';
      		        }
                }
                */
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

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

      var dataTable= $('#checks').DataTable({
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
          "url":'index.php/check/listingCheques',
          "dataSrc": function (json) {
            var output=[];
            var permission=$("#permission").val();
            permission= permission.split('-');
            $.each(json.data,function(index,item){              
              
              var td_2=item.numero;
              var td_3=item.rsbco;
              var td_4=item.apellido + ' ,' + item.nombre + (item.rsag != null && item.rsag != '' ? '( ' + item.rsag + ') ' : '');
              var td_5=item.importe;
              var d = new Date(item.vencimiento);
              var td_6= d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear();
              switch(item.estado){
                case 'AC':
                  var td_7='<small class="label bg-green">AC</small>';
                  break;

                case 'IN':
                  var td_7='<small class="label bg-yellow">IN</small>';
                  break;
              }
              

              var td_1="";
                  if(permission.indexOf("Edit")>0  ){
                    td_1+='<i  class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadCheque('+item.id+',\'Edit\')"></i>';
                  }

                  if(permission.indexOf("Del")>0){
                    td_1+='<i  class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadCheque('+item.id+',\'Del\')"></i>';
                  }

                  if(permission.indexOf("View")>0){
                    td_1+='<i  class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadCheque('+item.id+',\'View\')"></i>';
                  }
                output.push([td_2,td_3,td_4,td_5,td_6,td_7,td_1]);
            });
            return output;
          },
          error:function(the_error){
            console.debug(the_error);
          }
        }

    });
  });

  
  var idx = 0;
  var action = '';
  
  function LoadCheque(id__, action_){
  	idx = id__;
  	action = action_;
  	LoadIconAction('modalAction',action);
    WaitingOpen('Cargando...');
      $.ajax({
          	type: 'POST',
          	data: { id : idx, act: action_ },
    		url: 'index.php/check/getCheck', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyCheque").html(result.html);
                      $("#fecha").inputmask("dd-mm-yyyy",{ "clearIncomplete": true });
                      $("#vencimiento").inputmask("dd-mm-yyyy",{ "clearIncomplete": true });
                      $("#importe").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
			                setTimeout("$('#modalCheque').modal('show');",800);
                      setTimeout("$('#razon_social').focus();",1500);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalCheque');
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){
  	
  	if(action == 'View')
  	{
  		$('#modalCheque').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#bancoId').val() == '')
    {
    	hayError = true;
    }

    if($('#fecha').val().length != 10)
    {
      hayError = true;
    }

    if($('#numero').val() == '')
    {
      hayError = true;
    }

    if($('#vencimiento').val().length != 10)
    {
      hayError = true;
    }

    if($('#importe').val() == '')
    {
      hayError = true;
    }

    if($('#agenteId').val() == '')
    {
      hayError = true;
    }

    if(hayError == true){
    	$('#error').fadeIn('slow');
    	return;
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    debugger;
    	$.ajax({
          	type: 'POST',
          	data: { 
                    id : idx, 
                    act: action,
                    bancoId: $('#bancoId').val(),
                    fecha: $('#fecha').val(),
                    numero: $('#numero').val(),
                    vencimiento: $('#vencimiento').val(),
                    importe: $('#importe').val(),
                    agenteId: $('#agenteId').val(),
                    observacion: $('#observacion').val()
                  },
    		url: 'index.php/check/setCheck_', 
    		success: function(result){
                			WaitingClose();
                			$('#modalCheque').modal('hide');
                			setTimeout("cargarView('check', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalCheque');
    				},
          	dataType: 'json'
    		});
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalCheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Cheque</h4> 
      </div>
      <div class="modal-body" id="modalBodyCheque">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>