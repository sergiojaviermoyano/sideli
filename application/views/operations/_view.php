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
            <input type="text" class="form-control typeahead" data-provide="typeahead"  id="operationEmisorCuit" name="emisor_cuit" value=""  autocomplete="off"/>
            <input type="hidden" id="agente_emisor_id" name="agente_emisor_id" value="0" >
            
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12  col-xs-12">
            <label class="">Razon Social : </label>
            <input type="text" class="form-control" id="operationEmisorRazonSocial" name="emisor_razon_social"  autocomplete="off"/>
            
        </div>         
    </div>        
    <hr>
    
    <div class="form-group">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section ">
           <h3 class="h3_section">Cheque</h3>
        </div>

        <div class="col-lg-10 section_cheques">
            <div class="row ">                
                <div class="col-lg-3">
                    <label class="">Nro : </label>
                    <input type="text" class="form-control" id="operationChequeNro" name="nro_cheque" autocomplete="off"/>
                    
                </div>
                <div class="col-lg-3">
                    <label class="">Banco: </label>
                    <input type="text" class="form-control typeahead" id="operationBanco"  data-provide="typeahead" name="banco_nombre" autocomplete="off"/>
                    <input type="hidden" id="banco_id" name="banco_id" >
                    
                    
                </div> 
                <div class="col-lg-3">
                    <label class="">Importe : </label>
                    <input type="numeric" class="form-control cheque_importe_in" id="operationImporte" name="importe" style="text-align: right"/>
                    
                </div> 

                <div class="col-lg-1">
                    <label class=""></label>
                    <button class="btn btn-link   btn-xs btn-block add_checks_in"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>            
                </div> 
                
            </div> 

                
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
            <input type="text" class="form-control typeahead" data-provide="typeahead" id="operationTomadorCuit" name="tomador_cuit" autocomplete="off" />
            <input type="hidden" id="agente_tomador_id" name="agente_tomador_id" value="0">
        </div>
        <div class="col-lg-3">
            <label class="">Nombre : </label>
                <input type="text" class="form-control" id="operationTomadorNombre" name="tomador_nombre" autocomplete="off"/>
            
        </div> 
        <div class="col-lg-3">
        <label class="">Apellido : </label>
                <input type="text" class="form-control" id="operationTomadorApellido" name="tomador_apellido" autocomplete="off"/>
            
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
            <div class="col-lg-5 col-md-5 col-sm-12  col-xs-12">
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
                <div class="pago_salida col-lg-9">
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
        <h4>Cliente:       &nbsp;<span class="cliente_nombre"> </span> </h4>
        <h4>Domicilio:     &nbsp;<span class="cliente_domicilio"></span> </h4>
        <h4>Nro de Cuit:   &nbsp;<span class="cliente_cuit"></span> </h4>
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
<input type="hidden" id="feriados_field" value="<?php echo implode(',',$feriados);?>" >
<script src="<?php echo base_url('application/views/operations/_view.js');?>"></script>
