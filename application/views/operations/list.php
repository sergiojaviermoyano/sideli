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

                        <?php /*var_dump($list);*/?>

                        <table id="inversores" class="table table-bordered table-hover datatable">
                            <thead>
                            <tr >     
                                <th>Operacion Id</th>                          
                                <th >Tomador</th>
                                <!-- <th >Banco</th> -->
                                <th class="text-center">Fecha</th>
                                <th class="text-right">Importe</th>
                                <th class="text-right">Neto</th>
                                <!-- <th >Estado</th> -->
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list as $key => $item):?>
                                <tr>
                                    <td><?php echo $item['id']?> </td>
                                    <td><?php echo ($item['tomador']!='')? strtoupper($item['tomador']):' '?></td>
                                    
                                    <td class="text-center"><?php echo date("d-m-Y", strtotime($item['fecha_venc'])); ?></td>
                                    <td class="text-right"><?php echo "$ ".number_format($item['importe'], 2, ',', '.'); ?></td>
                                    <td style="text-align: right"><?php echo "$ ".number_format($item['neto'], 2, ',', '.'); ?></td>
                                    <!-- <td><input type="checkbox" value="1" id="inversorEstado" name="inversorEstado" <?php echo ((int)$item['estado']==1)?'checked':''?> ></td> -->
                                    <td style="text-align: center">
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
                                            //echo '<i class="fa fa-fw fa-dollar" style="color: #00a65a ; cursor: pointer; margin-left: 15px;" onclick="PrintLiq('.$item['id'].',\'View\')"></i> ';
                                            if($item['factura_tipo']=='' && $item['factura_nro']==''){
                                                echo '<i class="fa fa-fw fa-dollar" style="color: #00a65a ; cursor: pointer; margin-left: 15px;" onclick="addFactura('.$item['id'].')"></i> ';
                                            }else{
                                                echo '<i class="fa fa-fw fa-dollar" style="color: #00a65a ; cursor: pointer; margin-left: 15px;" onclick="PrintLiq('.$item['id'].',\'View\')"></i> ';
                                            }
                                        }
                                        ?>
                                        <input type="hidden" id="factura_<?php echo $item['id']?>" data-tipo="<?echo $item['factura_tipo']?>" data-nro="<?echo $item['factura_nro']?>">
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
<div class="modal fade" id="modalOperacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog  modal-lg modal-dialog_main op_modal-dialog" role="document" style="">
    <div class="modal-content op_modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Operación</h4> 
      </div>
      <div class="modal-body " id="modalBodyOperacion">
          <!-- CARGA FORMULARIO OPERACIONES -->
      </div>
      <div class="modal-footer">      
        <button type="button" class="btn btn-default btn-flat margin " data-dismiss="modal" style="margin-bottom:0px;">Cancelar</button>
        <button type="button" class="btn bg-navy btn-flat margin hidden" id="btnBack1" data-step="1">Volver</button>
        <button type="button" class="btn bg-navy btn-flat margin" id="btnNext1"  data-step="2">Siguiente</button>
        <button type="button" class="btn btn-primary hidden" id="btnSave" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFactura" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document" style="width:90% !important; height: 100%;  margin: 0;  padding: 0;">>
    <div class="modal-content" style="height: auto;min-height: 100%;  border-radius: 0;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Datos de Facturación</h4>
      </div>
        <div class="modal-body">
       
            <input type="hidden" id="o_id" >
            <div class="form-group">
                
                <label for="recipient-name" class="control-label">Tipo de Factura:</label>                
                <div class="row" >
                    <div class="col-lg-1 col-md-1 col-sm-1  col-xs-1">
                        <br>                
                        <label class="radio-inline">
                        <input type="radio" id="factura_tipo_a" name="factura_tipo"  value="A" checked> A
                        </label>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1  col-xs-1">
                        <br>                
                        <label class="radio-inline">
                        <input type="radio" id="factura_tipo_b" name="factura_tipo"  value="B" > B
                        </label>
                    </div>
                </div>

            </div>
            <br>
            <div class="form-group">
                <label for="factura_nro" class="control-label">Nro de Factura:</label>
                <input type="text" class="form-control" id="factura_nro" name="factura_nro" value="">
            </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="add_factura_btn" class="btn btn-info">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(function () {
        $('#inversores').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "desc" ]],
            
            "info": true,
            "autoWidth": true,
            "language": {
                "lengthMenu": "Ver _MENU_ filas por página",
                "zeroRecords": "No hay registros",
                "info": "Pag. _PAGE_ de _PAGES_",
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
                $("#modalBodyOperacion").html(result.html);
                $("#operationFechaVen").inputmask("dd-mm-yyyy",{ "clearIncomplete": true });
                //$("#operationImporte").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                $("#operationImporte").maskMoney({allowNegative: false, thousands:'.', decimal:',',allowZero:true,prefix:'$'});//.trigger('mask.maskMoney');
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
                
                setTimeout("$('#modalOperacion').modal('show');",800);
                setTimeout("$('#razon_social').focus();",1500);
            },
            error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalOperacion');
            },
            dataType: 'json'
        });
    };

    function Print(id__){

       

    WaitingOpen('Generando reporte...');
    LoadIconAction('modalAction__','Print');
    $("#link_download").attr('href',null);
    $.ajax({
            type: 'POST',
            data: {
                id : id__
            },
        url: 'index.php/operation/printOperation',
        success: function(result){
            console.log(result);
            WaitingClose();
            var url = "./assets/reports/" + result.file_url;
            $('#printDoc').attr('src', url);
            $("#link_download").attr('href',url);
            $('#modalPrint').modal('show');
            //setTimeout("$('#modalPrint').modal('show')",800);
        },
        error: function(result){

              WaitingClose();
              ProcesarError(result.responseText, 'modalPrint');
            },
            dataType: 'json'
        });
  }

  function addFactura(id){

    $("#modalFactura").find("#o_id").val(id);
    $("#modalFactura").modal('show');
  }

  function refresh_view(){
        WaitingOpen();
        $('#content').empty();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/operation/index/'+"<?php echo $permission; ?>",
            success: function(result){
                        WaitingClose();
                        $("#content").html(result);
                    },
            error: function(result){
                    WaitingClose();
                    ProcesarError(result.responseText, 'modalOper');
            },
            dataType: 'json'
        });
                  

    }
  $("#add_factura_btn").click(function(){
        var id=$("#modalFactura").find("#o_id").val();
        var factur_tipo= $("#modalFactura input[type=radio]:checked").val();
        if($("#factura_nro").val()==''){
            alert("Debe Ingresar un nro de Factura");
            $("#factura_nro").focus();
            return false;
        }else{
            var factura_nro=$("#factura_nro").val();
        }
        WaitingOpen("Cargando Factura");
        $.ajax({
            type: 'POST',
            data: {id: id, tipo : factur_tipo,nro : factura_nro},
            url: 'index.php/operation/setFactura',
            success: function(result){
                WaitingClose();
                $("#modalFactura").modal('hide');
                setTimeout("cargarView('operation', 'index', '"+$('#permission').val()+"');",1000);
            },
            error: function(result){
                  
                  ProcesarError(result.responseText, 'modalFactura');
            },
            dataType: 'json'
        });

        //refresh_view();    
      return false;
  })

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
                      $("#link_download").attr('href',url);
                      $('#modalPrint').modal('show')
                      //setTimeout("$('#modalPrint').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalPrint');
            },
            dataType: 'json'
        });
    }
    


</script>
