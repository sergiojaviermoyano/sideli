<form class="form-horizontal ope_form" action="">


   <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active" ><a href="#step1" id="step1_lk" aria-controls="step1" role="tab" data-toggle="tab">Cheque</a></li>
    <li role="presentation"  ><a href="#step2" id="step2_lk" aria-controls="step2" role="tab" data-toggle="tab">Inversor</a></li>
    <li role="presentation" ><a href="#step3"  id="step3_lk"aria-controls="step3" role="tab" data-toggle="tab">Resumen</a></li>  
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active " id="step1">
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
    <div role="tabpanel" class="tab-pane " id="step2">
        <div class="form-group">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
                <h3 class="h3_section">Inversores</h3>
            </div>
            <?php if(!is_null($data['inversores'])):?>
           
                <?php foreach($data['inversores'] as $key=>$item):?>
                <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
                    <br>                
                    <label class="radio-inline">
                        <input type="radio" id="OperationInversor1" name="inversor_id"  value="<?php echo $item['id']?>" <?php echo ($item['id']==1)?'checked':''?> ><?php echo $item['razon_social']?>
                    </label>
                </div>
                <?php endforeach;?>
            <?php endif;?>
            
        </div>
        <div class="form-group">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
                <h3 class="h3_section">Obvervación: </h3>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-12  col-xs-12">
                <br>
                <textarea name="observacion" id="operationObservacion" class="form-control" rows="20"></textarea>
            </div>

        </div>

         <div class="form-group">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
                <h3 class="h3_section">Cheques Entregados: </h3>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-12  col-xs-12">
                <br>
                <div class="row" id="check_outputs_1">
                    <div class="col-lg-3 col-md-3 col-sm-12  col-xs-12">
                        <button class="btn btn-succcess btn-lg add_check_out">Agregar Cheque</button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12  col-xs-12">
                        <button class="btn btn-succcess btn-lg add_check_out hidden" disabled>Agregar Tranferencia</button>
                    </div>
                    
                </div>   
                <div class="col-lg-9">
                    <table id="salid_tb" class="table table-responsive">
                    <thead>
                        <tr >
                            <th class="text-center">Banco</th>
                            <th class="text-center">Cheque Nroº</th>
                            <th class="text-center">Importe</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>     
                </div>            
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="step3">
        <h2>Liquidacion de Compra de Valores</h2>
        <h3>Inversor SRL</h3>
        <h4>CLIENTE:       <span> LOREM ITSU</span> </h4>
        <h4>DOMICILIO:     <span>MENDOZA 0</span> </h4>
        <h4>CUI:           <span>00-000000-0</span> </h4>
        <h4>OPERACION NRO: <span> 00000000</span> </h4>
        <table class="table table-bordered table-responsive table-striped">
            <thead>
                <tr>
                    <th>BANCO</th>
                    <th>Nro</th>
                    <th>Librador</th>
                    <th>Fecha Pago</th>
                    <th>Tasa</th>
                    <th>Dias</th>
                    <th>Importe $</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Banco Nacion</td>
                    <td>1234567890</td>                    
                    <td>Compañia de Librador</td>
                    <td>12-12-2017</td>
                    <td>7.0</td>
                    <td>15</td>
                    <td>150000.00</td>
                </tr>
                <tr>
                    <td>Banco Nacion</td>
                    <td>1234567890</td>                    
                    <td>Compañia de Librador</td>
                    <td>12-12-2017</td>
                    <td>7.0</td>
                    <td>15</td>
                    <td>150000.00</td>
                </tr>
                <tr>
                    <td>Banco Nacion</td>
                    <td>1234567890</td>                    
                    <td>Compañia de Librador</td>
                    <td>12-12-2017</td>
                    <td>7.0</td>
                    <td>15</td>
                    <td>150000.00</td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-6 col-md-5 col-sm-12 col-xs-10 hidden-xs pull-left">

            </div>
            <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 pull-right">
            <table class="table table-bordered table-responsive table-striped">
                
                
                <tr>
                    <td>Total Valores $</td>
                    <td>1505050505</td>
                </tr>
                <tr>
                    <td>Interes $</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>Imp Deb y Cred Bancario $</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>Valores otra Plaza $</td>
                    <td>000000</td>
                </tr>
                <tr>
                    <td>Comisiones $</td>
                    <td>000000</td>
                </tr>
                <tr>
                    <td>IVA $</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>SELLADO</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>Neto a Liquidar $</td>
                    <td>00000</td>
                </tr>
            
            </table>
        </div>
        </div>
        <!--
        <div class="col-lg-6 pull-left">
s
        </div>
        <div class="col-lg-6 pull-right">
            <table class="table table-bordered table-responsive table-striped">
                
                
                <tr>
                    <td>Total Valores $</td>
                    <td>1505050505</td>
                </tr>
                <tr>
                    <td>Interes $</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>Imp Deb y Cred Bancario $</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>Valores otra Plaza $</td>
                    <td>000000</td>
                </tr>
                <tr>
                    <td>Comisiones $</td>
                    <td>000000</td>
                </tr>
                <tr>
                    <td>IVA $</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>SELLADO</td>
                    <td>00000</td>
                </tr>
                <tr>
                    <td>Neto a Liquidar $</td>
                    <td>00000</td>
                </tr>
            
            </table>
        </div>-->
    </div>
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
        var step1_tb= $(this).find("button#btnNext1");
        var back1_tb= $(this).find("button#btnBack1");
        var save_tb= $(this).find("button#btnSave");
        var cheque_salida_nro= $(this).find("button#operationCheckOutNro");
        var cheque_salida_importe= $(this).find("button#operationCheckOutImporte");
        var cheque_salida_fecha= $(this).find("button#operationCheckOutFecha");
        var add_cheque_salida_bt= $(this).find("button.add_check_out");


        var calcular_valores=function(){
            //Esta funcion calcula todos los valores del formulario principal
            console.debug("====>> calcular_valores ");
           console.debug("\n==> Importe: %o",importe_input.val());
           var cantDias=dias_input.val();            
           var importe=parseFloat(importe_input.val());
           var tAnual=parseFloat(tasa_anual_input.val());
           var comision=parseFloat(comision_input.val().replace(',','.'));
           var impuesto=parseFloat(impuesto_cheque_input.data('valor').replace(',','.'));
           var gastos=parseFloat(gasto_input.val().replace(',','.'));
           var iva=parseFloat(iva_input.val().replace(',','.'));
           var sellado=parseFloat(sellado_input.val().replace(',','.'));
           
           
           console.debug("\n==> Importe: %o",importe);
           console.debug("==> TasaAnual: %o",tAnual);
           console.debug("==> cantDias: %o",cantDias);
           console.debug("==> comision: %o",comision);
           console.debug("==> impuesto: %o",impuesto );
           console.debug("==> iva: %o",iva );
           console.debug("==> sellado: %o",sellado );
           
           var interes= importe * (tAnual/365) * (cantDias/100);
           console.debug("\n==> Interes: %o",interes);
           interes_input.val(interes.toFixed(2));
           var comision_total= importe.toFixed(2)*comision / 100;
           console.debug("==> comision_total: %o",comision_total);
           comision_total_input.val(comision_total.toFixed(2));
           impuesto_cheque=(importe * impuesto)/100;
           console.debug("==> impuesto_cheque: %o",impuesto_cheque);
           impuesto_cheque_input.val(impuesto_cheque.toFixed(2));
           var compra= importe-interes-impuesto_cheque-gastos;
           console.debug("==> compra: %o",compra);
           var neto1=compra - comision_total;
           console.debug("==> neto1: %o",neto1);           
           var iva_total=(interes+comision_total) *(iva/100 );
           console.debug("==> iva_total: %o",iva_total);
           var sellado_total=(importe*(0.5/100))+(importe*(0.5/100)*(20/100))+(importe*(0.5/100)*(20/100));
           console.debug("==> sellado: %o",sellado);
           sellado_input.val(sellado_total.toFixed(2));           
           var neto_final=neto1-iva_total-sellado_total;
           console.debug("==> neto_final: %o",neto_final.toFixed(2));
           neto_input.val(neto_final.toFixed(2) );
            return false;
        }


        var validar_form_1=function(){
            console.debug("====> VALIDACION DE FORMULARIO 1:\n");            
            var _step1_inputs=$("#step1").find("input");
            //console.debug("===> INPUTS %o",_step1_inputs.length);
            var result=true;
            _step1_inputs.each(function(index, item){
               // console.debug("====> input[%o]: %o",index,item);
                if($(item).val().length<1){
                    alert("Todos los campos deben ser completados, vuelva a intentarlo.");
                    item.focus();
                    result=false;
                    return false;
                }
            });
            return result;
        };

        var validar_form_2=function(){
            console.debug("====> VALIDACION DE FORMULARIO 2:\n");     
            var radios=$("#step2").find("input[type=radio]");
            var texts=$("#step2").find("input[type=text]");
            var checked_radio=false;
            radios.each(function(index,item){
                if($(item).is(':checked')){
                    checked_radio=true;
                }
            });

            if(!checked_radio){
                alert("Debe Seleccionar un Inversor.");
                return false;
            }
            var result=true;
            if(texts.length==0){
                alert("Debe cargar al menos un cheque de salida.");
                return false;
            }else{
                texts.each(function(index,item){
                    if($(item).val().length<1){
                        alert("Debe completar todos los Datos de Cheques.");
                        $(item).focus();
                        result=false;
                        return false;
                    }
                });
            }

            console.debug("===> resultado: %o",result);

            return result;
        }
        
        importe_input.on('change',function(){
            calcular_valores();
        });
        dias_input.on('change',function(){
            calcular_valores();
        });
        comision_input.on('change',function(){
            console.debug("\====> comision_input\n");
            calcular_valores();
        });
        tasa_mensual_input.on('change',function(){
            console.debug("\n====> tasa_mensual_input\n");
            var tasa_mensual=parseFloat($(this).val().replace(',','.'));
            var new_tasa_anual=(tasa_mensual*12).toFixed(2);
            tasa_anual_input.val(new_tasa_anual);            
            calcular_valores();
        });
        gasto_input.on('change',function(){
            console.debug("\====> gasto_input\n");
            calcular_valores();
        });

        // CampoFecha de Veciento
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
                dias_input.val(Math.round(total_days)+2);
                dias_input.trigger('change');
            }
        });


        

        //Campo Banco autocomplete
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
                        alert("error_msg: " + error_msg);
                    },
                    dataType: 'json'
                };
                $.ajax(data_ajax);
            }
        });


        // Campo Emisor Cuit autocomplete 
        emisor_cuit_input.typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                query=query.split("-").join("");   
                query=query.split("_").join("");
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

        back1_tb.on('click',function(){
            var step=$(this).data('step');
            console.debug("===> BUTTON back1_tb clicked: %o",step);
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
            
            var tab_index=$('.nav-tabs > li.active').index();
            console.debug("===> BACK tab active: %o",tab_index);
            if(tab_index==0){
                $(this).addClass("hidden");
                step1_tb.removeClass("hidden");
            }else{
                $(this).removeClass("hidden");                
            }
            step1_tb.removeClass("hidden");
            
            
        });

        step1_tb.on('click',function(){
            var step=$(this).data('step');            
            console.debug("===> BUTTON step1_bt clicked: %o",step);
            var tab_index=$('.nav-tabs > li.active').index();
            console.debug("===> NEXT tab active: %o",tab_index);
            switch(tab_index){
                case 0:{
                    if(validar_form_1()){
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        back1_tb.removeClass("hidden");
                    }else{
                        return false;
                    }
                    $(this).removeClass("hidden");          
                    //return false;
                    break;
                }
                case 1:{
                    if(validar_form_2()){
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        $(this).addClass("hidden");
                        back1_tb.removeClass("hidden");
                    }else{
                        return false;
                    }
                }
                case 2:{
                     //$(this).addClass("hidden");
                     back1_tb.removeClass("hidden");
                }
                default:{
                    break;
                }
            }
            
            
        });

        
       
        
        
        add_cheque_salida_bt.on('click',function(){
            console.debug("====> Agregar Nuevo Cheque");
            total_rows=0;
            if($("#salid_tb").find("tbody tr:last").length>0){
                total_rows= $("#salid_tb").find("tbody tr").length;
                next_row=$("#salid_tb").find("tbody tr:last").data('next')+1;
            }else{
                total_rows=0;
                next_row=1;
            }

            var total_rows= $("#salid_tb").find("tbody tr").length;
            var last= $("#salid_tb").find("tbody tr:last").data();
            var new_row='<tr id="tr_'+(next_row-1)+'" data-next="'+next_row+'" >' ;
                new_row+='<td><input type="text" class="form-control banco typeahead" name="cheque_salida[\''+next_row+'\'][\'banco_id\']" id="operation_'+next_row+'_CheckOutBanco"  placeholder="Banco"></td>';
                new_row+='<td><input type="text" class="form-control nro" name="cheque_salida[\''+next_row+'\'][\'nro\']" id="operation_'+next_row+'_CheckOutNro"  placeholder="Nro Cheque"></td>';
                new_row+='<td><input type="text" class="form-control importe" name="cheque_salida[\''+next_row+'\'][\'importe\']" id="operation_'+next_row+'_CheckOutImporte"  placeholder="Importe"></td>';
                new_row+='<td><input type="text" class="form-control fecha datepicker" name="cheque_salida[\''+next_row+'\'][\'fecha\']" id="operation_'+next_row+'_CheckOutFecha"  placeholder="Fecha"></td>';
                new_row+='<td><button class="btn btn-danger btn-xs bt_check_delete" data-id="'+(next_row-1)+'">Eliminar</button></td>'
                new_row+='</tr>';
            $("#salid_tb").find("tbody").append(new_row);
            return false;
        });

        $(document).on('click','.fecha',function(){
            $(this).datepicker({
                minDate: today,
                dateFormat: 'dd-mm-yy',
                setDate: today,
            }).datepicker();
        });
        $(document).on('click','.banco',function(){
            $(this).typeahead({
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
                        alert("error_msg: " + error_msg);
                    },
                    dataType: 'json'
                };
                $.ajax(data_ajax);
            }
        }).typeahead();
        });

        $(document).on('click','.bt_check_delete',function(){
            var id=$(this).data('id');
            console.debug("===> DELETE CHEQUE: %o",id);

            if($("#salid_tb").find("tbody tr#tr_"+id).length>0){
                $("#salid_tb").find("tbody tr#tr_"+id).remove();
            }
            return false;
        });

        var print_liquidacion=function(){

            var cheques_salida=$("#step2").find("input[type=text]");

            return false;
        }

        

        
    });
</script>