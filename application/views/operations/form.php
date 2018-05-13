<form class="form-horizontal ope_form" action="">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#step1" data-toggle="tab">Valores</a></li>
    <li><a href="#step2" data-toggle="tab">Inversores</a></li>
    <li><a href="#step3" data-toggle="tab">Liquidación</a></li>
  </ul>


<div class="tab-content">   
    <div  class="tab-pane active" id="step1">
        
        <div class="form-group" >            
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
            <h3 class="h3_section">Tomador</h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
                <input id="tomador_cuit" name="tomador[cuit]"  class="form-control input-lg typeahead" data-provide="typeahead" autocomplete="off"  type="text" placeholder="CUIT">
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 clearfix">
                <input id="tomador_razo_social" name="tomador[razon_social]"  class="form-control input-lg" type="text" placeholder="Razón Social">
            </div>
            <input type="hidden" id="tomador_id" name="tomador[id]" >
            <!-- 
            <div class="col-lg-4">
                <input name="tomador['apellido']"   class="form-control input-lg" type="text" placeholder="Tipo( SRL, SA, etc)">
            </div> -->
        </div>
        <hr class="divider_hr">
        <div class="emisor_section form-group " >            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title_section">
                <h3 class="h3_section">Valores</h3>
            </div>
            <div class="form-group op_valor_item" data-num="0"> 
                <!-- Emisor 1 -->
                <div class="row">
                    <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor tag1 ">Emisor</label>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <input id="emisor_cuit" name="emisor[0][cuit]"  class="form-control input-lg emisor_cuit typeahead"   autocomplete="off" type="text" placeholder="CUIT">
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 clearfix">
                        <input id="emisor_razon_social" name="emisor[0][razon_social]"  class="form-control input-lg emisor_razon" autocomplete="off" type="text" placeholder="Razón Social">
                    </div>
                    <input type="hidden" id="emisor_id" name="emisor[0][id]" class="emisor_id">                    
                    <div class="col-lg-3 text-left" style="">                
                        <button type="button" class="bt_add_emisor btn btn-flat btn-success" data-num_item="1"> <i class="fa fa-plus"></i>Emisor</button>
                    </div>

                </div>
                <!-- Emisor 1 -->

                <div class="row cheques_section">
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cheque :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Nro</small>
                            <input  id="cheque_nro" name="emisor[0][cheque][0][nro]"  class="cheque_nro form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Nro">   
                        </div>
                        <div class="col-lg-4 col-md-2 col-sm-12">
                            <small>Banco</small>
                            <input id="cheque_banco" name="emisor[0][cheque][0][banco]"  class="cheque_banco  form-control input-lg typeahead" autocomplete="off" type="text" placeholder="Banco">   
                            <input id="cheque_banco_id" name="emisor[0][cheque][0][banco_id]" class="cheque_banco_id" type="hidden" >
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-12">
                            <small>Importe</small>
                            <input id="cheque_importe" name="emisor[0][cheque][0][importe]"  class="form-control input-lg cheque_importe text-right" autocomplete="off" type="text" placeholder="Importe $">   
                        </div>    
                    </div>
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Plazo :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Fecha Ven.</small>
                            <input id="cheque_fecha" name="emisor[0][cheque][0][fecha]"  class="cheque_fecha form-control input-lg "  data-provide="datepicker" autocomplete="off" type="text" placeholder="Vencimiento">   
                        </div>  
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Nro Días</small>
                            <input id="cheque_dias" name="emisor[0][cheque][0][dias]"  class="cheque_dia form-control "  type="text" placeholder="Días">   
                            <input type="checkbox" id="min_dias1" class="cheque_set_min_dias" > min Días 
                            <input type="hidden" id="min_days1" class="min_days" > 
                        </div> 
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Tasas :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>% Mensual</small>
                            <input id="tasa_mensual" name="emisor[0][cheque][0][tasa_mensual]"  class="cheque_tasa_mensual form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Mensual" >   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Anual</small>
                            <input id="tasa_anual" name="emisor[0][cheque][0][tasa_anual]"  class="cheque_tasa_anual form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Anual" readonly>   
                        </div> 
                    </div>
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Interes :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Interes</small>
                            <input id="interes" name="emisor[0][cheque][0][interes]"  class="cheque_interes form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Cliente $">   
                        </div> 
                        <label for="emisor_cuit" class="col-lg-3 col-md-1 col-sm-12 control-label emisor ">Comisión :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>%</small>
                            <input id="comision_porcentaje" name="emisor[0][cheque][0][comision_porcentaje]"  class="cheque_comision_porcentaje form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="%">   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>$</small>
                            <input id="comision_importe" name="emisor[0][cheque][0][comision_importe]"  class="cheque_comision_importe form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="$" readonly>   
                        </div> 
                    </div>
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cobro Varios :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Impuesto Cheque</small>
                            <input id="impuesto" name="emisor[0][cheque][0][impuesto]"  class="cheque_impuesto form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Impuesto Cheque" readonly>   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Gasto</small>
                            <input id="gasto" name="emisor[0][cheque][0][gasto]"  class="cheque_gasto form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Gastos $" readonly>   
                        </div>                        
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>IVA </small>
                            <input id="iva" name="emisor[0][cheque][0][iva]"  class="cheque_iva form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="IVA(21%)" readonly>   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <small>Sellado $</small>
                            <input id="sellado" name="emisor[0][cheque][0][sellado]"  class="cheque_sellado form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Sellado" readonly>   
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <br>
                            <input type="checkbox" id="editar1" class="cheque_editar_varios" >  Editar   
                        </div>
                    </div>               
                    <br>     
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Neto x Cheque :</label>
                        <div class="col-lg-3 col-md-2 col-sm-12">
                        <input id="neto_cheche" name="emisor[0][cheque][0][neto]"  class="cheque_neto form-control input-lg " autocomplete="off" type="text" placeholder="Neto x Cheque">   
                            <input id="compra" name="emisor[0][cheque][0][compra]"  class="cheque_compra form-control input-lg " type="hidden" >   
                        </div> 
                    </div>
                    <div class="col-lg-12  text-right" style="">            
                        <button type="button" class="btn_add_cheque btn btn-flat btn-success" data-num="1"> <i class="fa fa-plus"></i>Cheque</button>
                    </div>
                </div>
            </div>
        </div>
        

        
        <!--  ITEM DE CHEQUE -->
        
        <div class="form-group neto_final_div">
            <label for="Neto Total" class="col-lg-9 col-md-9 col-sm-12 control-label  ">Neto Total :</label>
                        
            <div class="col-lg-3 col-md-3 col-sm-12 text-left">
                <input id="neto_final" name="neto_final"  class="neto_final form-control input-lg text-right" type="text" placeholder="Neto Total de Valores">
            </div> 
        </div>
    </div>
    <div  class="tab-pane" id="step2">
        <div class="form-group">
            <div class="col-lg-2 ">
                <h3 class="h3_section">Inversores: </h3>
            </div>
            <?php if(!is_null($data['inversores'])):?>
            
            <?php foreach($data['inversores'] as $key=>$item):?>
            <div class="col-lg-4 col-md-4 col-sm-6  col-xs-12">
                <label class="radio-inline">
                <input type="radio" id="OperationInversor1" name="inversor_id" data-domicilio="<?php echo $item['domicilio']?>" data-cuit="<?php echo $item['cuit']?>" data-name="<?php echo $item['razon_social']?>"  value="<?php echo $item['id']?>" <?php echo ($item['id']==1)?'checked':''?> ><?php echo $item['razon_social']?>
                </label>
            </div>
            <?php endforeach;?>
        <?php endif;?>
        </div>
        <div class="form-group">
            <div class="col-lg-2 ">
                <h3 class="h3_section">Observaión: </h3>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12  col-xs-12">                
                <textarea name="observacion" id="operationObservacion" class="form-control" rows="20"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-2 ">
                <h3 class="h3_section">Cheques: </h3>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-12  col-xs-12">
                <table class="table table_cheque">
                    <thead>
                        <tr >
                            <th class="text-center" >Banco</th>
                            <th class="text-center">Cheque Nro</th>
                            <th class="text-center">Importe</th>
                            <th class="text-center">Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">
                            <button class="btn bg-orange btn-flat margin add_check_out "> <span class="icon-check-money"></span> Agregar Cheque</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-2 ">
                <h3 class="h3_section">Tranferencias: </h3>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-12  col-xs-12">
                <table class="table table_tranfer">
                    <thead>
                        <tr >                            
                            <th class="text-center" >Banco</th>
                            <th class="text-center">CBU Nro Alias</th>
                            <th class="text-center">Importe</th>
                            <th class="text-center">Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">
                            <button class="btn bg-olive btn-flat margin add_tranfe_out "> <i class="fa fa-exchange" aria-hidden="true"></i>Agregar Cheque</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            
            </div>
        </div>
        <div class="form-group bg-gray">
            <div class="col-lg-2 ">
                <h3 class="h3_section">Neto</h3>                
            </div>
            <div id="account_final" class="col-lg-7 col-md-7 col-sm-12  col-xs-12 text-right">
                <div class="col-lg-6">
                    <span class="neto_span"> </span>
                </div>
                <div class="col-lg-6">
                    Total: <span class="neto_total_final"> </span>
                </div>
               
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12  col-xs-12 text-right alert_tope hidden">
                <p class="text-red">El monto No debe ser Mayor a <br> <span class="neto_span"> </span></p>
            </div>

            
        </div>

    </div>
    <div  class="tab-pane" id="step3">
        <div class="col-lg-12">
            <h2>Liquidación de Compra de Valores:</h2>
            <h3>Soluciones y Finansas Empresarias S.A</h3>
            <h4>Cliente:       &nbsp;<span class="cliente_nombre"> </span> </h4>
            <h4>Domicilio:     &nbsp;<span class="cliente_domicilio"></span> </h4>
            <h4>Nro de Cuit:   &nbsp;<span class="cliente_cuit"></span> </h4>
        </div>
        <div class="row">
            <div class="col-lg-12"> 
                <table class="table table-bordered" id="table_cheque_final">
                    <thead>
                        <tr > 
                            <th class="text-center">Banco</th>
                            <th class="text-center">Nro</th>
                            <th class="text-center">Librador</th>
                            <th class="text-center">Fecha de Pago</th>
                            <th class="text-center">Tasa</th>
                            <th class="text-center">Días</th>
                            <th class="td_detail">Importe</th>
                        </tr>
                    </thead>
                    <tbody class="main">
                    </tbody>
                    <tbody  class="secundary">                    
                    </tbody>
                    
                </table> 

                 
            </div>
        </div>
        
    </div>
  </div>


</form>

<?php include_once 'form_js.php'; ?>