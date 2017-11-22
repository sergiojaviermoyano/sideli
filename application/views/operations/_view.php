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
            <input type="text" class="form-control typeahead" data-provide="typeahead"  id="operationEmisorCuit" name="emisor_cuit" value="" />
            <input type="hidden" id="agente_emisor_id" name="agente_emisor_id" value="0" >
            
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12  col-xs-12">
            <label class="">Razon Social : </label>
            <input type="text" class="form-control" id="operationEmisorRazonSocial" name="emisor_razon_social" />
            
        </div> 
        <!--
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">Nombre : </label>
            <input type="text" class="form-control" id="operationEmisorNombre" name="emisor_nombre" />
            
        </div> 
        <div class="col-lg-3 col-md-3 col-sm-4  col-xs-12">
            <label class="">Apellido : </label>
            <input type="text" class="form-control" id="operationEmisorApellido" name="emisor_apellido" />
            
        </div> -->

        <!--<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 pull-right">
            <label class=""> </label>
            <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button> 
        </div>-->
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
            <input type="text" class="form-control typeahead" id="operationBanco"  data-provide="typeahead" name="banco_nombre" />
            <input type="hidden" id="banco_id" name="banco_id" >
            
            
        </div> 
        <div class="col-lg-3">
            <label class="">Importe : </label>
            <input type="numeric" class="form-control" id="operationImporte" name="importe" style="text-align: right"/>
            
        </div> 
        <div class="col-lg-9 offset-3" style="display: none" id="errorDuplicado">
            <span class="text-red ">¡El cheque ingresado ya fue registrado!</span>
            <input type="hidden" id="chequeValido" value="0">
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
            <input type="hidden" id="agente_tomador_id" name="agente_tomador_id" value="0">
        </div>
        <div class="col-lg-3">
            <label class="">Nombre : </label>
                <input type="text" class="form-control" id="operationTomadorNombre" name="tomador_nombre" />
            
        </div> 
        <div class="col-lg-3">
        <label class="">Apellido : </label>
                <input type="text" class="form-control" id="operationTomadorApellido" name="tomador_apellido" />
            
        </div> 
         <!--<div class="col-lg-1 pull-right">
            <label class=""> </label>
            <button type="button" class="btn btn-success btn-block">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button> 
        </div>-->
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
                    <input type="text" class="form-control" id="operationDias" name="nro_dias" style="text-align: right" />
            </div> 
        
        </div>
        
        <div>
            <div class="col-lg-2 text-right">
                <h3 class="h3_section">Tasas</h3>
            </div>
            <div class="col-lg-1">
                <label class="">Mensual : </label>
                <input type="text" class="form-control" id="opterationTasaMensual" name="tasa_mensual" value="<?php echo number_format($data['valores']['tasa'],2,".",",") ?>" style="text-align: right"/>
            </div>
            <div class="col-lg-1">
                <label class="">Anual: </label>
                <input type="text" class="form-control" id="opterationTasaAnual" name="tasa_anual" value="<?php echo number_format($data['valores']['tasa']*12,2,".",",") ?>" readonly="readonly" style="text-align: right" />
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
                <input type="text" class="form-control" id="opterationInteres" name="interes" style="text-align: right"/>
            </div>
            
        
        </div>        
        
        <div class="">
            <div class="col-lg-2 text-right">
                <h3 class="h3_section">Comisión:</h3>
            </div>
            <div class="col-xs-1 text-center">
                <label class="">% : </label>
                <input type="text" class="form-control" id="opterationComision" name="comision_valor" value="<?php echo number_format($data['valores']['comision'],2,".",",") ?>" style="text-align: right" />
            </div>
            <div class="col-lg-1 ">
                <label class="">$: </label>
                <input type="text" class="form-control" id="opterationComisionTotal" name="comision_total" readonly="readonly" style="text-align: right"  />
            </div> 
        
        </div>

        <div class="">
            <div class="col-lg-1 text-right">
                <h3 class="h3_section">Neto:</h3>
            </div>
            <div class="col-xs-2">
                <label class="">$ : </label>
                <input type="text" class="form-control" id="operationNeto" name="neto" readonly="readonly" style="text-align: right"/>
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
            <input type="text" class="form-control" id="operationImpuestoCheque" data-valor=" <?php echo number_format($data['valores']['impuestos'],3,".",",") ?>" name="impuesto_cheque" style="text-align: right"/>
        </div>

        <div class="col-lg-2">
            <label class="">Gastos: </label>
            <input type="text" class="form-control" id="operationGasto" name="gastos"  value=" <?php echo number_format($data['valores']['gastos'],2,".",",") ?>" style="text-align: right"/>
        </div>
        <div class="col-lg-2 text-right">
            <h3 class="h3_section"></h3>
        </div>
        <div class="col-lg-1 ">
            <label class="">IVA (21%): </label>
            <input type="text" class="form-control" id="operationIva" name="iva" value="0.00" style="text-align: right"/>
        </div>
        <div class="col-lg-1 ">
            <label class="">Sellado: </label>
            <input type="text" class="form-control" id="operationSellado" name="sellado" value="0.00" style="text-align: right"/>
        </div>        

    </div>
    </div>

    <input type="hidden" name="compra" id="operationCompra" >
    <input type="hidden" name="subtotal" id="operationSubtotal" >

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
                    <input type="radio" id="OperationInversor1" name="inversor_id" data-domicilio="<?php echo $item['domicilio']?>" data-cuit="<?php echo $item['cuit']?>" data-name="<?php echo $item['razon_social']?>"  value="<?php echo $item['id']?>" <?php echo ($item['id']==1)?'checked':''?> ><?php echo $item['razon_social']?>
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
                    <div class="col-lg-8 col-md-8 col-sm-12  col-xs-12">
                    <button class="btn btn-info btn-lg add_check_out "> <span class="icon-check-money"></span> Agregar Cheque</button>
                    <button class="btn btn-success btn-lg add_tranfer_out"><i class="fa fa-exchange" aria-hidden="true"></i>Agregar Tranferencia</button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12  col-xs-12 text-right">
                        <h3>Neto: <span class="neto_total"></span></h3>                        
                    </div>
                    
                </div>   
                <div class="col-lg-9">
                    <table id="salid_tb" class="table table-responsive hidden">
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
                    <table id="salid_tb_tranferencia" class="table table-responsive hidden">
                        <thead>
                            <tr>
                                <th class="text-center">Banco</th>
                                <th class="text-center">CBU Nro / Alias</th>
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
        <h4>CLIENTE:       &nbsp;<span class="cliente_nombre"> LOREM ITSU</span> </h4>
        <h4>DOMICILIO:     &nbsp;<span class="cliente_domicilio">MENDOZA 0</span> </h4>
        <h4>CUI:           &nbsp;<span class="cliente_cuit">00-000000-0</span> </h4>
        <!-- <h4>OPERACION NRO: <span > 00000000</span> </h4> -->
        <table id="resumen_cheque" class="table table-bordered table-responsive table-striped">
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
                
            </tbody>
        </table>
        
        <div class="row">
            <div class="col-lg-6 col-md-5 col-sm-12 col-xs-10 hidden-xs pull-left">

            </div>
            <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 pull-right">
            <table class="resumen_liquidacion" class="table table-bordered table-responsive table-striped">
                
                <tbody>
                <tr>
                    <td>Total Valores $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="total_de_valores text-right">1505050505</td>
                </tr>
                <tr>
                    <td>Interes $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="interes text-right">00000</td>
                </tr>
                <tr>
                    <td>Imp Deb y Cred Bancario $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="impuesto text-right">00000</td>
                </tr>
                <tr>
                    <td>Valores otra Plaza $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="otros text-right">000000</td>
                </tr>
                <tr>
                    <td>Comisiones $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="comision text-right" >000000</td>
                </tr>
                <tr>
                    <td>IVA $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="iva text-right">00000</td>
                </tr>
                <tr>
                    <td>SELLADO</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="sellado text-right">00000</td>
                </tr>
                <tr class="tr_neto">
                    <td>Neto a Liquidar $</td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td style="width: 25%;"><p>&nbsp;</p></td>
                    <td class="netos text-right">00000</td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="settings">Form 4</div>
  </div>
    
    
       
</form>


<script>

//definicion de una variable para una operación 
var operation = operationClass;
var emisor_data={
    id:             -1,
    cuit:           '',
    nombre:         '',
    apellido:       '', 
    razon_social:   '',
    domicilio: ''
};
var tomador_data={
    id:             -1,
    cuit:           '',
    nombre:         '',
    apellido:       '', 
    razon_social:   '',
    domicilio: ''
};
var banco_1={
    banco_id:0,
    nombre:''
};

    $(function(){

        var emisor_cuit_input=$(this).find("input#operationEmisorCuit");
        var tenedor_cuit_input=$(this).find("input#operationTomadorCuit");
        var banco_input=$(this).find("input#operationBanco");
        /**/var cheque_nro=$(this).find("#operationChequeNro");
        /**/var importe_input=$(this).find("input#operationImporte");
        /**/var fecha_vencimiento=$(this).find("input#operationFechaVen");
        /**/var dias_input=$(this).find("input#operationDias");
        /**/var tasa_mensual_input=$(this).find("input#opterationTasaMensual");
        /**/var tasa_anual_input=$(this).find("input#opterationTasaAnual");
        /**/var interes_input=$(this).find("input#opterationInteres");
        /**/var comision_input=$(this).find("input#opterationComision");
        /**/var comision_total_input=$(this).find("input#opterationComisionTotal");
        /**/var impuesto_cheque_input=$(this).find("input#operationImpuestoCheque");
        /**/var gasto_input=$(this).find("input#operationGasto");
        /**/var iva_input=$(this).find("input#operationIva");
        /**/var sellado_input=$(this).find("input#operationSellado");
        var compra_input=$(this).find("input#operationCompra");
        var subtotal_input=$(this).find("input#operationSubtotal");
        var neto_input=$(this).find("input#operationNeto");
        var step1_tb= $(this).find("button#btnNext1");
        var back1_tb= $(this).find("button#btnBack1");
        var save_tb= $(this).find("button#btnSave");
        var cheque_salida_nro= $(this).find("button#operationCheckOutNro");
        var cheque_salida_importe= $(this).find("button#operationCheckOutImporte");
        var cheque_salida_fecha= $(this).find("button#operationCheckOutFecha");
        var add_cheque_salida_bt= $(this).find("button.add_check_out");
        var add_tranfer_salida_tb= $(this).find("button.add_tranfer_out");

        var neto_total=0;
        var total_valores_pagar=0;
        var cliente_data=null;

        var calcular_valores=function(){
            //Esta funcion calcula todos los valores del formulario principal
           //console.debug("====>> calcular_valores ");
           //console.debug("\n==> Importe: %o",importe_input.val());
           operation.cheque.nro = cheque_nro.val();
           operation.cheque.dias = dias_input.val();
           operation.cheque.vencimiento = fecha_vencimiento.val();
           operation.cheque.importe = parseFloat(importe_input.val());
           //var cantDias=dias_input.val();            
           //var importe=parseFloat(importe_input.val());
           operation.tasaA = parseFloat(tasa_anual_input.val());
           operation.tasaM = parseFloat(tasa_mensual_input.val());
           //var tAnual=parseFloat(tasa_anual_input.val());
           operation.interesCliente = parseFloat(interes_input.val());
           operation.comisionPor = parseFloat(comision_input.val().replace(',','.'));
           operation.comisionImp = parseFloat(comision_total_input.val().replace(',','.'));
           //var comision=parseFloat(comision_input.val().replace(',','.'));
           operation.impuestoCheque = parseFloat('1.2');//parseFloat(impuesto_cheque_input.data('valor').replace(',','.'));
           //console.de
           //var impuesto=parseFloat(impuesto_cheque_input.data('valor').replace(',','.'));
           //console.debug("====> aca_: %o",gasto_input.val());
           operation.gastos = (gasto_input.val()!='')? parseFloat(gasto_input.val().replace(',','.')): 0;
           //var gastos=parseFloat(gasto_input.val().replace(',','.'));
           operation.importeIVA = parseFloat(iva_input.val().replace(',','.'));
           //var iva=parseFloat(iva_input.val().replace(',','.'));
           operation.importeSellado = parseFloat(sellado_input.val().replace(',','.'));
           //var sellado=parseFloat(sellado_input.val().replace(',','.'));
           
           
           //console.debug("\n==> Importe: %o",operation.cheque.importe);
           //console.debug("==> TasaAnual: %o",operation.tasaA);
           //console.debug("==> cantDias: %o",operation.cheque.dias);
           //console.debug("==> comision: %o",operation.comisionPor);
           //console.debug("==> impuesto: %o",operation.impuestoCheque );
           //console.debug("==> iva: %o",operation.importeIVA );
           //console.debug("==> sellado: %o",operation.importeSellado );
           
           var interes= operation.cheque.importe * (operation.tasaA/365) * (operation.cheque.dias/100);
           operation.interes=interes;
           
           //console.debug("\n==> Interes: %o",interes);
           interes_input.val(interes.toFixed(2));
           operation.comisionImp = operation.cheque.importe.toFixed(2)*operation.comisionPor / 100;
           //console.debug("==> comision_total: %o",operation.comisionImp);
           comision_total_input.val(operation.comisionImp.toFixed(2));
           operation.impuestoCheque=(operation.cheque.importe * operation.impuestoCheque)/100;
           console.debug("==> impuesto_cheque: %o",operation.impuestoCheque);
           impuesto_cheque_input.val(operation.impuestoCheque.toFixed(2));
           var compra= operation.cheque.importe-interes-operation.impuestoCheque-operation.gastos;
           //console.debug("==> compra: %o",compra);
           var neto1=compra - operation.comisionImp;
           //console.debug("==> neto1: %o",neto1);           
           operation.importeIVA=(interes+operation.comisionImp) *(21/100 ); //!!!!! (iva/100 )
           iva_input.val(operation.importeIVA.toFixed(2));
           //console.debug("==> iva_total: %o",operation.importeIVA);
           operation.importeSellado=(operation.cheque.importe*(0.5/100))+(operation.cheque.importe*(0.5/100)*(20/100))+(operation.cheque.importe*(0.5/100)*(20/100));
           //console.debug("==> sellado: %o",operation.importeSellado);
           sellado_input.val(operation.importeSellado.toFixed(2));           
           var neto_final=neto1-operation.importeIVA-operation.importeSellado;
           //console.debug("==> neto_final: %o",neto_final.toFixed(2));
           neto_input.val(neto_final.toFixed(2) );
           neto_total=neto_final.toFixed(2);

           $("span.neto_total").html(" $ "+neto_total);
            return false;
        }


        var validar_form_1=function(){
            //console.debug("====> VALIDACION DE FORMULARIO 1:\n");            
            var _step1_inputs=$("#step1").find("input");
            //console.debug("===> INPUTS %o",_step1_inputs.length);
            var result=true;
            _step1_inputs.each(function(index, item){
               // console.debug("====> input[%o]: %o",index,item);
                if($(item).val().length<1 || $('#chequeValido').val() == '0'){
                    alert("Todos los campos deben ser completados, vuelva a intentarlo.");
                    item.focus();
                    result=false;
                    return false;
                }
            });
            return result;
        };

        var validar_form_2=function(){
            //console.debug("====> VALIDACION DE FORMULARIO 2:\n");     
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

            return result;
        }
        cheque_nro.on('change',function(){
            validarCheque($("#banco_id").val(), cheque_nro.val());
        });
        
        importe_input.on('change',function(){
            calcular_valores();
        });
        dias_input.on('change',function(){
            var today =new Date();
            if(dias_input.val() != ""){
                today.setDate(today.getDate()+ parseInt(dias_input.val()) - 2);
            } 
            var mes = today.getMonth() + 1;
            fecha_vencimiento.val(today.getDate()+'-'+mes+'-'+today.getFullYear()); 
            calcular_valores();
        });
        comision_input.on('change',function(){
            //console.debug("\====> comision_input\n");
            calcular_valores();
        });
        tasa_mensual_input.on('change',function(){
            //console.debug("\n====> tasa_mensual_input\n");
            var tasa_mensual=parseFloat($(this).val().replace(',','.'));
            var new_tasa_anual=(tasa_mensual*12).toFixed(2);
            tasa_anual_input.val(new_tasa_anual);            
            calcular_valores();
        });
        gasto_input.on('change',function(){
            //console.debug("\====> gasto_input\n");
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
                //dias_input.trigger('change');
                calcular_valores();
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
            }, updater: function(item) {
                var data = map[item];
                
                $("#banco_id").val(data.id);
                banco_1=data;
                validarCheque($("#banco_id").val(), cheque_nro.val());
                return data.razon_social;
            }
        });

        //validador de cheques duplicados
        var validarCheque=function(banco, numero){
            if( banco != "" &&  numero != ""){
                WaitingOpen('Validando Cheque...');
                $.ajax({
                type: 'POST',
                data: {id: banco, nro: numero },
                url: 'index.php/check/validate', 
                success: function(result){
                    if(result == 0){
                        //cheque ya registrado
                        $('#chequeValido').val('0');
                        $('#errorDuplicado').show();
                    } else {
                        //cheque sin registrar 
                        $('#chequeValido').val('1');
                        $('#errorDuplicado').hide();
                    }
                    WaitingClose();
                },
                error: function(result){
                    WaitingClose();
                    alert("Error al validar el cheque ingresado. Intente nuevamente la operación.");
                    $('#chequeValido').val('0');
                },
                dataType: 'json'
            });
            }else {
                //nothing
            }
            return;
        }


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
                //console.debug("==> updater emisor: %o",emisor_cuit_input.val());
                console.debug("==> updater data.cuit: %o",data);
                $("#agente_emisor_id").val(0);
                if(emisor_cuit_input.val().length==data.cuit.length && emisor_cuit_input.val()!=data.cuit){
                    //$("#operationEmisorNombre").val(null);
                    //$("#operationEmisorApellido").val(null);
                    $("#operationEmisorRazonSocial").val(null);
                    $("#agente_emisor_id").val('0');
                    emisor_data={
                        id:             -1,
                        cuit:           '',
                        nombre:         '',
                        apellido:       '', 
                        razon_social:   '',
                        domicilio: ''
                    };
                    console.debug("===> operationEmisorApellido - emisor_data: %o",emisor_data);
                    
                    return emisor_cuit_input.val();
                }else{
                    //$("#operationEmisorNombre").val(data.nombre);
                    //$("#operationEmisorApellido").val(data.apellido);
                    $("#agente_emisor_id").val(data.id);
                    $("#operationEmisorRazonSocial").val(data.razon_social);
                    emisor_data=data;
                    //console.debug("===> operationEmisorApellido - emisor_data: %o",emisor_data);
                     
                    return data.cuit;
                }
                
                
                
            }
        });
        
        

        //$(document).on('change',"#operationEmisorApellido",function(){
        $(document).on('change',"#operationEmisorRazonSocial",function(){
            if($("#agente_emisor_id").val()==0){
                emisor_data.id=0;
                emisor_data.cuit=$('#operationEmisorCuit').val();               
                emisor_data.nombre=$('#operationEmisorRazonSocial').val();
                emisor_data.apellido="";
                emisor_data.razon_social=$(this).val();
                emisor_data.domicilio="";
                console.debug("===> nuevo emisor");
            }
            
            return false;
        });

        $(document).on('change',"#operationTomadorApellido",function(){
            if($("#agente_tomador_id").val()==0){
                
            //console.debug("===> operationTomadorApellido - tomador_data: %o",tomador_data);
            tomador_data.id=0;
            tomador_data.cuit=$('#operationTomadorCuit').val();
            tomador_data.nombre=$('#operationTomadorNombre').val();
            tomador_data.apellido=$('#operationTomadorApellido').val();
            tomador_data.razon_social=$('#operationTomadorNombre').val()+" "+$('#operationTomadorApellido').val();
            tomador_data.domicilio=" fgfgfgg";
            //console.debug("===> operationTomadorApellido - emisor_data: %o",tomador_data);
            
            //console.debug("===> nuevo Tomador");
            }
            return false;
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
                        //console.debug("ERROR Tenedor: %o",error_msg);
                        alert("error_msg: " + error_msg);
                    },
                    dataType: 'json'
                };
                $.ajax(data_ajax);
                
            }, updater: function(item) {
                var data = map[item];
                /*
                console.debug("ERROR: %o",data);
                $("#operationTomadorNombre").val(data.nombre);
                $("#operationTomadorApellido").val(data.apellido);
                $("#agente_tomador_id").val(data.id);
                
                return data.cuit;*/
               // console.debug("==> updater emisor: %o",emisor_cuit_input.val());
                //console.debug("==> updater data.cuit: %o",data.cuit);
                if(tenedor_cuit_input.val().length==data.cuit.length && tenedor_cuit_input.val()!=data.cuit){
                    $("#operationTomadorNombre").val(null);
                    $("#operationTomadorApellido").val(null);
                    $("#agente_tomador_id").val('0');
                    tomador_data={
                        id:             -1,
                        cuit:           '',
                        nombre:         '',
                        apellido:       '', 
                        razon_social:   '',
                        domicilio: ''
                    };
                    console.debug("===> operationEmisorApellido - emisor_data: %o",tomador_data);                        
                    return tenedor_cuit_input.val();
                }else{
                    $("#operationTomadorNombre").val(data.nombre);
                    $("#operationTomadorApellido").val(data.apellido);
                    $("#agente_tomador_id").val(data.id);
                    tomador_data=data;
                    console.debug("===> operationEmisorApellido - emisor_data: %o",tomador_data);                     
                    return data.cuit;
                }
            }
        });

        back1_tb.on('click',function(){
            var step=$(this).data('step');
            //console.debug("===> BUTTON back1_tb clicked: %o",step);
            $('.nav-tabs > .active').prev('li').find('a').trigger('click');
            
            var tab_index=$('.nav-tabs > li.active').index();
            //console.debug("===> BACK tab active: %o",tab_index);
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
            //console.debug("===> BUTTON step1_bt clicked: %o",step);
            var tab_index=$('.nav-tabs > li.active').index();
            //console.debug("===> NEXT tab active: %o",tab_index);
            switch(tab_index){
                case 0:{
                    if(validar_form_1()){
                        $('.nav-tabs >   .active').next('li').find('a').trigger('click');
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
                        save_tb.removeClass("hidden");
                    }else{
                        return false;
                    }
                }
                case 2:{
                     //$(this).addClass("hidden");
                     print_liquidacion();
                     back1_tb.removeClass("hidden");
                }
                default:{
                    break;
                }
            }
            
            
        });

        
       
        
        
        add_cheque_salida_bt.on('click',function(){
            
            if($("#salid_tb").is( ":hidden" ))
                console.debug("====> Agregar Nuevo Cheque");{
                $("#salid_tb").removeClass("hidden");
            }

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
                new_row+='<td><input type="text" class="form-control banco typeahead"  name="cheque_salida['+next_row+'][banco_nombre]" id="operation_'+next_row+'_CheckOutBanco"  data-id="'+next_row+'" placeholder="Banco">';
                new_row+='<input type="hidden"   name="cheque_salida['+next_row+'][banco_id]" id="banco_id_'+next_row+'" ></td>';
                new_row+='<td><input type="text" class="form-control nro" name="cheque_salida['+next_row+'][nro]" id="operation_'+next_row+'_CheckOutNro"  placeholder="Nro Cheque" style="text-align: right"></td>';
                new_row+='<td><input type="text" class="form-control importe" name="cheque_salida['+next_row+'][importe]" id="operation_'+next_row+'_CheckOutImporte"  placeholder="Importe" style="text-align: right"></td>';
                new_row+='<td><input type="text" class="form-control fecha datepicker" name="cheque_salida['+next_row+'][fecha]" id="operation_'+next_row+'_CheckOutFecha"  placeholder="Fecha"></td>';
                new_row+='<td><button class="btn btn-danger btn-xs bt_check_delete" data-id="'+(next_row-1)+'">Eliminar</button></td>'
                new_row+='</tr>';
            $("#salid_tb").find("tbody").append(new_row);
            $('input.form-control.importe').maskMoney({allowNegative: false, thousands:'', decimal:'.'});//.trigger('mask.maskMoney');
            $('input.form-control.fecha').datepicker({
                minDate: today,
                dateFormat: 'dd-mm-yy',
                setDate: today,
            });
            return false;
        });


        add_tranfer_salida_tb.on('click',function(){
            
            total_rows=0;
            var table=$('#salid_tb_tranferencia');

            if(table.is( ":hidden" ))
                console.debug("====> Agregar Nuevo Cheque");{
                table.removeClass("hidden");
            }

            if(table.find("tbody tr:last").length>0){
                total_rows= table.find("tbody tr").length;
                next_row=table.find("tbody tr:last").data('next')+1;
            }else{
                total_rows=0;
                next_row=1;
            }

            var total_rows= $("#salid_tb").find("tbody tr").length;
            var last= table.find("tbody tr:last").data();
            var new_row='<tr id="tr_'+(next_row-1)+'" data-next="'+next_row+'" >' ;
                new_row+='<td><input type="text" class="form-control transfe_banco typeahead"  name="tranferencia_salida['+next_row+'][banco_nombre]" id="operation_'+next_row+'_TransfeOutBanco"  data-id="'+next_row+'" placeholder="Banco">';
                new_row+='<input type="hidden"   name="tranferencia_salida['+next_row+'][banco_id]" id="transfe_banco_id_'+next_row+'" ></td>';
                new_row+='<td><input type="text" class="form-control nro" name="tranferencia_salida['+next_row+'][cbu]" id="operation_'+next_row+'_TransfeOutCbu"  placeholder="Nro / Alias CBU" maxlength="22" style="text-align: right"></td>';
                new_row+='<td><input type="text" class="form-control importe" name="tranferencia_salida['+next_row+'][importe]" id="operation_'+next_row+'_TransfeOutImporte"  placeholder="Importe" style="text-align: right"></td>';
                new_row+='<td><input type="text" class="form-control fecha datepicker" name="tranferencia_salida['+next_row+'][fecha]" id="operation_'+next_row+'_TransfeOutFecha"  placeholder="Fecha"></td>';
                new_row+='<td><button class="btn btn-danger btn-xs bt_check_delete" data-id="'+(next_row-1)+'">Eliminar</button></td>'
                new_row+='</tr>';
            $("#salid_tb_tranferencia").find("tbody").append(new_row);
            $('input.form-control.importe').maskMoney({allowNegative: false, thousands:'', decimal:'.'});//.trigger('mask.maskMoney');
            $('input.form-control.fecha').datepicker({
                minDate: today,
                dateFormat: 'dd-mm-yy',
                setDate: today,
            });
            return false;
        });
        
        

        $(document).on('keyup','.importe',function(){
            var input_importes=$("#salid_tb").find("input.form-control.importe");
            var total=0;
            input_importes.each(function(index,item){
            //console.debug("====> $(item).val(): %o",$(item).val());                
                total+=parseFloat($(item).val());
            });
            //console.debug("====> _importe: %o",total.toFixed(2));
            //console.debug("====> input_importes: %o",parseFloat(neto_total).toFixed(2));
            if(total>parseFloat(neto_total).toFixed(2)){
                alert(" Los importes de los cheques Agregados no pueden superar al Neto a pagar: ");
                return false;
            }
            total_valores_pagar=total;
        });

        $(document).on('click','.banco',function(){
            var id=$(this).data('id');
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
            }, updater: function(item) {
                var data = map[item];
                
                $("#banco_id_"+id+"").val(data.id);
                return data.razon_social;
            }
        }).typeahead();
        });

        $(document).on('click','.transfe_banco',function(){
            var id=$(this).data('id');
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
            }, updater: function(item) {
                var data = map[item];
                
                $("#transfe_banco_id_"+id+"").val(data.id);
                return data.razon_social;
            }
        }).typeahead();
        });

        $(document).on('click','.bt_check_delete',function(){
            var id=$(this).data('id');
            //console.debug("===> DELETE CHEQUE: %o",id);

            if($("#salid_tb").find("tbody tr#tr_"+id).length>0){
                $("#salid_tb").find("tbody tr#tr_"+id).remove();
            }
            return false;
        });

        var print_liquidacion=function(){
            var tr_cheques_salida=$("#step2").find('table#salid_tb tbody').find('tr');//.find("input[type=text]");
            var liquidacion_final=[];
            
            tr_cheques_salida.each(function(idex,item){
                var inputs=$(item).find("input[type=text]");
                var temp=[];
                inputs.each(function(sindex,sitem){
                    temp.push($(sitem).val());                                                           
                });
                temp.splice(2, 0, emisor_data.apellido+", "+emisor_data.nombre);
                temp.splice(3, 0, operation.tasaM);
                temp.splice(4, 0, operation.cheque.dias);                
                liquidacion_final.push(temp);                
            });

            var tabla_cheque_salida="";
            /*$.each(liquidacion_final,function(index,item){      
                console.debug("==> Item: %o",item);          
                tabla_cheque_salida+="<tr>";
                tabla_cheque_salida+="<td>"+item[0]+"</td>";
                tabla_cheque_salida+="<td>"+item[1]+"</td>";
                tabla_cheque_salida+="<td>"+item[2]+"</td>";
                tabla_cheque_salida+="<td>"+item[6]+"</td>";
                tabla_cheque_salida+="<td>"+item[3]+"</td>";
                tabla_cheque_salida+="<td>"+item[4]+"</td>";
                tabla_cheque_salida+="<td>"+parseFloat(item[5]).toFixed(2)+"</td>";
                tabla_cheque_salida+="</tr>";
            });   */       
            //console.debug("=> banco_1: %o",banco_1);
            tabla_cheque_salida+="<tr>";
            tabla_cheque_salida+="<td>"+banco_1.razon_social+"</td>";
            tabla_cheque_salida+="<td>"+operation.cheque.nro+"</td>";
            tabla_cheque_salida+="<td>"+emisor_data.razon_social+"</td>";
            tabla_cheque_salida+="<td>"+operation.cheque.vencimiento+"</td>";
            
            tabla_cheque_salida+="<td>"+operation.tasaM+"</td>";
            tabla_cheque_salida+="<td>"+operation.cheque.dias+"</td>";
            tabla_cheque_salida+="<td class='text-rigth'>"+parseFloat(operation.cheque.importe).toFixed(2)+"</td>";
            tabla_cheque_salida+="</tr>";

            //console.debug("===> operation: %o",operation);
            //console.debug("===> emisor_data: %o",emisor_data);

            $("#resumen_cheque").find("tbody").empty().append(tabla_cheque_salida);
            var inversor_data=$('input[name=inversor_id]:checked').data();
            $("#step3").find("h3").html(inversor_data.name);
            $("span.cliente_nombre").html(tomador_data.razon_social);
            $("span.cliente_domicilio").html(tomador_data.domicilio);
            $("span.cliente_cuit").html(tomador_data.cuit);
            $("td.total_de_valores").html(parseFloat(operation.cheque.importe).toFixed(2));
            $("td.interes").html(operation.interes.toFixed(2));
            $("td.impuesto").html(operation.impuestoCheque.toFixed(2));
            $("td.otros").html(operation.gastos.toFixed(2));
            $("td.comision").html(operation.comisionImp.toFixed(2));
            $("td.iva").html(operation.importeIVA.toFixed(2));
            $("td.sellado").html(operation.importeSellado.toFixed(2));
            $("td.netos").html(parseFloat(neto_total).toFixed(2));
            return false;
        }

        save_tb.click(function(){
            var form_data=$("form").serialize();
            WaitingOpen();
            $.ajax({
                type: 'POST',
                data: $("form").serialize(),
                url: 'index.php/operation/addOperation', 
                success: function(result){
                    WaitingClose();
                    $('#modalInversor').modal('hide');
                    setTimeout("cargarView('operation', 'index', '"+$('#permission').val()+"');",1000);        
                    
                },
                error: function(result){
                    WaitingClose();
                   // alert("error");
                },
                dataType: 'json'
            });
            return false;
        }); 

        
    });
</script>