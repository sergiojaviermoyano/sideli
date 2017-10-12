<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Operaciones</h3>
                    <?php
                        if (strpos($permission,'Add') !== false) {
                        echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadOperation(0,\'Add\')" id="btnAdd">Agregar</button>';
                        }
                    ?>
                    </div><!-- /.box-header -->
                   
                    <div class="box-body">
                        <table id="inversores" class="table table-bordered table-hover datatable">
                            <thead>
                            <tr>                               
                                <th >Tenedor</th>
                                <th >Banco</th>
                                <th >Fecha Vencimiento</th>
                                <th >Importe</th>
                                <th >Neto</th>
                                <!-- <th >Estado</th> -->
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list as $key => $item):?>
                                <tr>
                                    <td><?php echo $item['tomador']?></td>
                                    <td><?php echo $item['banco']?></td>
                                    <td class="cuit"><?php echo $item['fecha_venc']; ?></td>
                                    <td><?php echo "$ ".$item['importe']; ?></td>
                                    <td><?php echo "$ ".$item['neto']; ?></td>
                                    <!-- <td><input type="checkbox" value="1" id="inversorEstado" name="inversorEstado" <?php echo ((int)$item['estado']==1)?'checked':''?> ></td> -->
                                    <td>
                                        <?php 
                                        /*
                                        if (strpos($permission,'Edit') !== false) {
                                            echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadOperation('.$item['id'].',\'Edit\')"></i>';
                                        }*/
                                        if (strpos($permission,'View') !== false) {
                                            echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadOperation('.$item['id'].',\'View\')"></i>';
                                        }
                                        if (strpos($permission,'View') !== false) {
                                            echo '<i class="fa fa-fw fa-file-text-o" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="Print('.$item['id'].',\'View\')"></i> ';
                                        }
                                        if (strpos($permission,'View') !== false) {
                                            echo '<i class="fa fa-fw fa-dollar" style="color: #00a65a ; cursor: pointer; margin-left: 15px;" onclick="PrintLiq('.$item['id'].',\'View\')"></i> ';
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
  <div class="modal-dialog  modal-lg modal-dialog_main" role="document" style="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Operación</h4> 
      </div>
      <div class="modal-body" id="modalBodyInversor">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary hidden" id="btnBack1" data-step="1">Volver</button>
        <button type="button" class="btn btn-primary" id="btnNext1"  data-step="2"      >Siguiente</button>
        <button type="button" class="btn btn-primary hidden" id="btnSave" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(function () {
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
  
    function LoadOperation(id__, action_){
        idx = id__;
        action = action_;
        LoadIconAction('modalAction',action);
        WaitingOpen('Cargando...');
        $.ajax({
            type: 'POST',
            data: { id : idx, act: action_ },
            url: 'index.php/operation/getOperation', 
            beforeSend:function(){
                WaitingClose();
            },
            success: function(result){
                //console.debug(result);
                $("#modalBodyInversor").html(result.html);
                $("#operationFechaVen").inputmask("dd-mm-yyyy",{ "clearIncomplete": true });
                $("#operationImporte").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#opterationTasaMensual").maskMoney({allowNegative: false, thousands:'', decimal:'.', allowZero: true});
                $("#opterationTasaAnual").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#opterationInteres").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#opterationComision").maskMoney({allowNegative: false, thousands:'', decimal:'.', allowZero: true});
                $("#opterationComisionTotal").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#operationNeto").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#operationImpuestoCheque").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#operationGasto").maskMoney({allowNegative: true, thousands:'', decimal:'.', allowZero: true});
                $("#operationIva").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#operationSellado").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                
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

    function Print(id__){
    WaitingOpen('Generando reporte...');
    LoadIconAction('modalAction__','Print');
    $.ajax({
            type: 'POST',
            data: {
                    id : id__
                  },
        url: 'index.php/operation/printOperation',
        success: function(result){
                      WaitingClose();
                      var url = "./assets/reports/" + result;
                      $('#printDoc').attr('src', url);
                      setTimeout("$('#modalPrint').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalPrint');
            },
            dataType: 'json'
        });
  }

  function PrintLiq(id__){
    WaitingOpen('Generando reporte...');
    LoadIconAction('modalAction__','Print');
    $.ajax({
            type: 'POST',
            data: {
                    id : id__
                  },
        url: 'index.php/operation/printLiquidacion',
        success: function(result){
                      WaitingClose();
                      var url = "./assets/reports/" + result;
                      $('#printDoc').attr('src', url);
                      setTimeout("$('#modalPrint').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalPrint');
            },
            dataType: 'json'
        });
  }
    /*
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
      url: 'index.php/operation/setInvestor', 
      success: function(result){
        WaitingClose();
        $('#modalInversor').modal('hide');
        setTimeout("cargarView('operation', 'index', '"+$('#permission').val()+"');",1000);        
        
      },
      error: function(result){
        WaitingClose();
        alert("error");
      },
      dataType: 'json'
      });
  });*/


</script>
