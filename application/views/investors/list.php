<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Inversores</h3>
                    <?php
                        if (strpos($permission,'Add') !== false) {
                        echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadInversor(0,\'Add\')" id="btnAdd">Agregar</button>';
                        }
                    ?>
                    </div><!-- /.box-header -->
                   
                    <div class="box-body">
                        <table id="inversores" class="table table-bordered table-hover datatable">
                            <thead>
                            <tr>
                               
                                <th >Razon Social</th>
                                <th >CUIT</th>
                                <th >Domicilio</th>
                                <th >Habilitado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list as $key => $item):?>
                                <tr>
                                    <td><?php echo $item['razon_social']?></td>
                                    <td class="cuit"><?php echo $item['cuit']; ?></td>
                                    <td><?php echo $item['domicilio']; ?></td>
                                    <td><input type="checkbox" value="1" id="inversorEstado" name="inversorEstado" <?php echo ((int)$item['estado']==1)?'checked':''?> ></td>
                                    <td>
                                        <?php 
                                        if (strpos($permission,'Edit') !== false) {
                                            echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadInversor('.$item['id'].',\'Edit\')"></i>';
                                        }
                                        if (strpos($permission,'Del') !== false) {
                                            echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadInversor('.$item['id'].',\'Del\')"></i>';
                                        }
                                        if (strpos($permission,'View') !== false) {
                                            echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadInversor('.$item['id'].',\'View\')"></i> ';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </tabl>
                    </div> 
            </div>
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modalInversor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Insersor</h4> 
      </div>
      <div class="modal-body" id="modalBodyInversor">
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
        //$("#groups").DataTable();
        $('#inversores').DataTable({
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

    var idx = 0;
    var action = '';
  
    function LoadInversor(id__, action_){
        idx = id__;
        action = action_;
        LoadIconAction('modalAction',action);
        WaitingOpen('Cargando...');
        $.ajax({
            type: 'POST',
            data: { id : idx, act: action_ },
            url: 'index.php/investor/getInvestor', 
            success: function(result){
                console.debug(result);
                console.debug(result.html);
                WaitingClose();
                $("#modalBodyInversor").html(result.html);
                /*$("#fecha").inputmask("dd-mm-yyyy",{ "clearIncomplete": true });*/
                $("#InversorCuit").inputmask("99-99999999-9",{ "clearIncomplete": true });
                //$("#importe").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                setTimeout("$('#modalInversor').modal('show');",800);
                setTimeout("$('#razon_social').focus();",1500);
            },
            error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalInversor');
            },
            dataType: 'json'
        });
    };
    $('#btnSave').on('click',function(){
  	console.debug("===> TES");
    if(action == 'View'){
  		$('#modalInversor').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#InversorRazonSocial').val() == '')
    {
      hayError = true;
    }

    if($('#InversorCuit').val() == '')
    {
      hayError = true;
    }
    if($('#InversorDomicilio').val() == '')
    {
      hayError = true;
    }
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
        act: action, 
        id: $('#InversorId').val(),    
        cuit: $('#InversorCuit').val(),
        razon_social: $('#InversorRazonSocial').val(),
        domicilio: $('#InversorDomicilio').val(),
        estado: $('#InversorEstado').val(),
      },
      url: 'index.php/investor/setInvestor', 
      success: function(result){
        WaitingClose();
        $('#modalInversor').modal('hide');
        setTimeout("cargarView('investor', 'index', '"+$('#permission').val()+"');",1000);        
        
      },
      error: function(result){
        WaitingClose();
        alert("error");
      },
      dataType: 'json'
      });
  });

</script>
