<form class="form-horizontal ope_form" action="">


   <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <div class="form-group">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
           <h3 class="h3_section">Emisor</h3>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">CUIT : </label>
            <input type="text" class="form-control typeahead" data-provide="typeahead"  id="operationEmisorCuit" name="agente_emisor_id" value="" />
            
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">Nombre : </label>
            <input type="text" class="form-control" id="operationEmisorNombre" name="emisor_nombre" />
            
        </div> 
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">Apellido : </label>
            <input type="text" class="form-control" id="operationEmisorApellido" name="emisor_apellido" />
            
        </div> 
        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 pull-right">
            <label class=""> </label>
            <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button> 
        </div>
    </div>        
    <hr>
    
    <div class="form-group">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section ">
           <h3 class="h3_section">Cheque</h3>
        </div>
        <div class="col-lg-3">
            <label class="">Nro : </label>
            <input type="text" class="form-control" id="operationChequeNro" name="nro_cheque" />
            
        </div>
        <div class="col-lg-3">
            <label class="">Banco: </label>
            <input type="text" class="form-control typeahead" id="operationBanco"  data-provide="typeahead" name="banco_id" />
            
        </div> 
        <div class="col-lg-3">
            <label class="">Importe : </label>
            <input type="numeric" class="form-control" id="operationImporte" name="importe" />
            
        </div> 
    </div>                
    <hr>
    
    <div class="form-group">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
           <h3 class="h3_section">Tomador</h3>
        </div>
        <div class="col-lg-3">
            <label class="">CUIT : </label>
                <input type="text" class="form-control typeahead" data-provide="typeahead" id="operationTomadorCuit" name="tomador_cuit" />
            
        </div>
        <div class="col-lg-3">
            <label class="">Nombre : </label>
                <input type="text" class="form-control" id="operationTomadorNombre" name="tomador_nombre" />
            
        </div> 
        <div class="col-lg-3">
        <label class="">Apellido : </label>
                <input type="text" class="form-control" id="operationTomadorApellido" name="tomador_apellido" />
            
        </div> 
         <div class="col-lg-1 pull-right">
            <label class=""> </label>
            <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button> 
        </div>
    </div>
          <hr>
    <div class="form-group">
        
        <div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
                <h3 class="h3_section">Plazo</h3>
            </div>
            <div class="col-lg-2">
                <label class="">Vencimiento : </label>
                <input type="text" class="form-control" id="operationFechaVen" name="fecha_ven" />
            </div>
            <div class="col-lg-2">
                    <label class="">Dias: </label>
                    <input type="text" class="form-control" id="operationDias" name="nro_dias" />
            </div> 
        
        </div>
        
        <div>
            <div class="col-lg-2 text-right">
                <h3 class="h3_section">Tasas</h3>
            </div>
            <div class="col-lg-1">
                <label class="">Mensual : </label>
                <input type="text" class="form-control" id="opterationTasaMensual" name="tasa_mensual" value="<?php echo number_format($data['valores']['tasa'],2,",",".") ?>" />
            </div>
            <div class="col-lg-1">
                <label class="">Anual: </label>
                <input type="text" class="form-control" id="opterationTasaAnual" name="tasa_anual" value="<?php echo number_format($data['valores']['tasa']*12,2,",",".") ?>" />
            </div> 
        
        </div>
        
    </div>      
   <hr>
   <div class="form-group">
        
        <div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
            <h3 class="h3_section">Intereses</h3>
        </div>
            <div class="col-lg-2">
                <label class="">Cliente : </label>
                <input type="text" class="form-control" id="opterationInteres" name="interes" />
            </div>
            
        
        </div>        
        
        <div class="">
            <div class="col-lg-2 text-right">
                <h3 class="h3_section">Comisión:</h3>
            </div>
            <div class="col-xs-1 text-center">
                <label class="">% : </label>
                <input type="text" class="form-control" id="opterationComision" name="comision_valor" value="<?php echo number_format($data['valores']['comision'],2,",",".") ?>"/>
            </div>
            <div class="col-lg-1 ">
                <label class="">$: </label>
                <input type="text" class="form-control" id="opterationComisionTotal" name="comision_total" />
            </div> 
        
        </div>

        <div class="">
            <div class="col-lg-1 text-right">
                <h3 class="h3_section">Neto:</h3>
            </div>
            <div class="col-xs-2">
                <label class="">$ : </label>
                <input type="text" class="form-control" id="operationNeto" name="neto" />
            </div>
            
        
        </div>
        
    </div>      
   <hr>
    <div class="form-group">
        <div class="col-lg-2 ">
            <h3 class="h3_section">Cobros Varios</h3>
        </div>
        <div class="col-lg-2">
            <label class="">Impuesto Cheque: </label>
            <input type="text" class="form-control" id="operationImpuestoCheque" data-valor=" <?php echo number_format($data['valores']['impuestos'],3,",",".") ?>" name="impuesto_cheque" />
        </div>

        <div class="col-lg-2">
            <label class="">Gastos: </label>
            <input type="text" class="form-control" id="operationGasto" name="gastos"  value=" <?php echo number_format($data['valores']['gastos'],2,",",".") ?>"/>
        </div>
        <div class="col-lg-2 text-right">
            <h3 class="h3_section"></h3>
        </div>
        <div class="col-lg-1 ">
            <label class="">IVA: </label>
            <input type="text" class="form-control" id="operationIva" name="iva" value="21" />
        </div>
        <div class="col-lg-1 ">
            <label class="">Sellado: </label>
            <input type="text" class="form-control" id="operationSellado" name="sellado" value="0.0" />
        </div>        

    </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">Form 2</div>
    <div role="tabpanel" class="tab-pane" id="messages">Form 3</div>
    <div role="tabpanel" class="tab-pane" id="settings">Form 4</div>
  </div>
    
    
       
</form>


<script>
    $(function(){

        var emisor_cuit_input=$(this).find("input#operationEmisorCuit");
        var tenedor_cuit_input=$(this).find("input#operationTomadorCuit");
        var banco_input=$(this).find("input#operationBanco");
        var importe_input=$(this).find("input#operationImporte");
        var fecha_vencimiento=$(this).find("input#operationFechaVen");
        var dias_input=$(this).find("input#operationDias");
        var tasa_mensual_input=$(this).find("input#opterationTasaMensual");
        var tasa_anual_input=$(this).find("input#opterationTasaAnual");
        var interes_input=$(this).find("input#opterationInteres");
        var comision_input=$(this).find("input#opterationComision");
        var comision_total_input=$(this).find("input#opterationComisionTotal");
        var impuesto_cheque_input=$(this).find("input#operationImpuestoCheque");
        var gasto_input=$(this).find("input#operationGasto");
        var iva_input=$(this).find("input#operationIva");
        var sellado_input=$(this).find("input#operationSellado");
        var neto_input=$(this).find("input#operationNeto");
        
        
        importe_input.on('change',function(){
            dias_input.trigger('change');
        });
        dias_input.on('change',function(){
           console.debug("\n==> Importe: %o",importe_input.val());
           var importe=parseFloat(importe_input.val());
           var tAnual=parseFloat(tasa_anual_input.val());
           var cantDias=$(this).val();
           var comision=parseFloat(comision_input.val().replace(',','.'));
           var impuesto=parseFloat(impuesto_cheque_input.data('valor').replace(',','.'));
           var gastos=parseFloat(gasto_input.val().replace(',','.'));
           var iva=parseFloat(iva_input.val().replace(',','.'));
           var sellado=parseFloat(sellado_input.val().replace(',','.'));
           
           console.debug("\n==> Importe: %o",importe);
           console.debug("\n==> TasaAnual: %o",tAnual);
           console.debug("\n==> cantDias: %o",cantDias);
           console.debug("\n==> comision: %o",comision);
           console.debug("\n==> impuesto: %o",impuesto );
           console.debug("\n==> iva: %o",iva );
           console.debug("\n==> sellado: %o",sellado );
           
           var interes= importe * (tAnual/365) * (cantDias/100);
           console.debug("\n==> Interes: %o",interes);
           interes_input.val(interes.toFixed(2));
           var comision_total= importe.toFixed(2)*comision / 100;
           console.debug("\n==> comision_total: %o",comision_total);
           comision_total_input.val(comision_total.toFixed(2));
           impuesto_cheque=(importe * impuesto)/100;
           console.debug("\n==> impuesto_cheque: %o",impuesto_cheque);
           impuesto_cheque_input.val(impuesto_cheque.toFixed(2));
           var compra= importe-interes-impuesto_cheque-gastos;
           console.debug("\n==> compra: %o",compra);
           var neto1=compra - comision_total;
           console.debug("\n==> neto1: %o",neto1);
           
           var iva_total=(interes+comision_total) *(iva/100 );
           console.debug("\n==> iva_total: %o",iva_total);
           var sellado_total=(importe*(0.5/100))+(importe*(0.5/100)*(20/100))+(importe*(0.5/100)*(20/100));
           console.debug("\n==> sellado: %o",sellado);
           sellado_input.val(sellado_total.toFixed(2));
           
           var neto_final=neto1-iva_total-sellado_total;
           console.debug("\n==> neto_final: %o",neto_final.toFixed(2));
           neto_input.val(neto_final.toFixed(2) );
           
           
           
           
        });
        var d = new Date();
        var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        fecha_vencimiento.datepicker({
            minDate: today,
            dateFormat: 'dd-mm-yy',
            setDate: today,
            onSelect:function(dateText,int){
                var from_date=today;
                var days_to=new Date(int.currentYear,int.currentMonth,int.currentDay);
                
                var total_days = (days_to - from_date) / (1000 * 60 * 60 * 24);
                console.debug("===> int:%o",total_days);
                dias_input.val(Math.round(total_days)+2);
                dias_input.trigger('change');
            }
        });
        banco_input.typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                var data_ajax={
                    type: "POST",
                    url: 'bank/buscadorDeBancos',
                     
                    data: { action: 'search', code: query, type: 'E' },
                    success: function(data) {
                        if(data==false){
                            return false;
                        }
                        objects = [];
                        map = {};                        
                        $.each(data, function(i, object) {
                           var key = object.razon_social
                            map[key] = object;
                            objects.push(key);
                        });
                        return process(objects);
                    },
                    error: function(error_msg) {
                        console.debug("ERROR: %o",error_msg);
                        alert("error_msg: " + error_msg);
                    },
                    dataType: 'json'
                };
                $.ajax(data_ajax);
            }
        });
        
        emisor_cuit_input.typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                
                console.debug("==>emisor: %o",query);
                
                query=query.split("-").join("");
                console.debug(query);                
                query=query.split("_").join("");
                console.debug(query);
                var data_ajax={
                    type: "POST",
                    url: 'agent/buscadorDeAgentes',
                     
                    data: { action: 'search', code: query, type: 'E' },
                    success: function(data) {
                        if(data==false){
                            return false;
                        }
                        objects = [];
                        map = {};

                        $.each(data, function(i, object) {
                           var key = object.cuit + " - " + object.razon_social
                            map[key] = object;
                            objects.push(key);
                        });
                        return process(objects);
                    },
                    error: function(error_msg) {
                        console.debug("ERROR: %o",error_msg);
                        alert("error_msg: " + error_msg);
                    },
                    dataType: 'json'
                };
                $.ajax(data_ajax);
                
            }, updater: function(item) {
                var data = map[item];
                console.debug("ERROR: %o",data);
                $("#operationEmisorNombre").val(data.nombre);
                $("#operationEmisorApellido").val(data.apellido);
                return data.cuit;
            }
        });

        tenedor_cuit_input.typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
               
                var data_ajax={
                    type: "POST",
                    url: 'agent/buscadorDeAgentes',
                     
                    data: { action: 'search', code: query, type: 'T' },
                    success: function(data) {
                         if(data==false){
                    return false;
                }
                        objects = [];
                        map = {};
                        $.each(data, function(i, object) {
                            var key = object.cuit + " - " + object.razon_social
                            map[key] = object;
                            objects.push(key);
                        });
                        return process(objects);
                    },
                    error: function(error_msg) {
                        console.debug("ERROR Tenedor: %o",error_msg);
                        alert("error_msg: " + error_msg);
                    },
                    dataType: 'json'
                };
                $.ajax(data_ajax);
                
            }, updater: function(item) {
                var data = map[item];
                console.debug("ERROR: %o",data);
                $("#operationTomadorNombre").val(data.nombre);
                $("#operationTomadorApellido").val(data.apellido);
                return data.cuit;
            }
        });
        
    });
</script>