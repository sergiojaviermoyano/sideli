<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Valores</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="values" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Tasa</th>
                <th>Impuesto</th>
                <th>Gastos</th>
                <th>Comisión</th>
                <th width="20%">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($list)){
                  if($list != false)
                	foreach($list as $v)
      		        {
  	                echo '<tr>';                  
  	                echo '<td style="text-align: right">'.$v['tasa'].'</td>';
                    echo '<td style="text-align: right">'.$v['impuestos'].'</td>';
                    echo '<td style="text-align: right">'.$v['gastos'].'</td>';
                    echo '<td style="text-align: right">'.$v['comision'].'</td>';
                    echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
                        echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadValue('.$v['id'].',\'Edit\')"></i>';
                    }
                    if (strpos($permission,'View') !== false) {
                        echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadValue('.$v['id'].',\'View\')"></i> ';
                    }
                        
                    echo '</td>';
  	                echo '</tr>';
      		        }
                }
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
    //$("#groups").DataTable();
    $('#values').DataTable({
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
  });

  
  var id_ = 0;
  var action = '';
  
  function LoadValue(id__, action_){
  	id_ = id__;
  	action = action_;
  	LoadIconAction('modalAction',action);
    WaitingOpen('Cargando...');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action_ },
    		url: 'index.php/valuegral/getValue', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyValuegral").html(result.html);
                      $("#tasa").maskMoney({allowNegative: false, thousands:'', decimal:'.', allowZero: true});
                      $("#impuestos").maskMoney({allowNegative: false, thousands:'', decimal:'.', allowZero: true});
                      $("#gastos").maskMoney({allowNegative: false, thousands:'', decimal:'.', allowZero: true});
                      $("#comision").maskMoney({allowNegative: false, thousands:'', decimal:'.', allowZero: true});
			                setTimeout("$('#modalValuegral').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalValuegral');
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){
  	
  	if(action == 'View')
  	{
  		$('#modalValuegral').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#taza').val() == '')
    {
    	hayError = true;
    }

    if($('#impuestos').val() == '')
    {
      hayError = true;
    }

    if($('#gastos').val() == '')
    {
      hayError = true;
    }

    if($('#comision').val() == '')
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
                    id : id_, 
                    act: action, 
                    tasa: $('#tasa').val(),
                    impu: $('#impuestos').val(),
                    gast: $('#gastos').val(),
                    comi: $('#comision').val()
                  },
    		url: 'index.php/valuegral/setValue', 
    		success: function(result){
                			WaitingClose();
                			$('#modalValuegral').modal('hide');
                			setTimeout("cargarView('valuegral', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalValuegral');
    				},
          	dataType: 'json'
    		});
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalValuegral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Valores</h4> 
      </div>
      <div class="modal-body" id="modalBodyValuegral">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>