<form class="form-horizontal ope_form" action="">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="operacion" class="active"><a href="#step1" aria-controls="step1" role="tab" data-toggle="tab">Valores</a></li>
    <li role="operacion">               <a href="#step2" aria-controls="step2" role="tab" data-toggle="tab">Inversores</a></li>
    <li role="operacion">               <a href="#step3" aria-controls="step3" role="tab" data-toggle="tab">Resuneb</a></li>
  </ul>


<div class="tab-content">   
    <div role="tabpanel" class="tab-pane active" id="step1">
        
        <div class="form-group" >            
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 title_section">
            <h3 class="h3_section">Tomador</h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12">
                <input id="tomador_cuit" name="tomador[cuit]"  class="form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="CUIT">
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
                        <input id="emisor_cuit" name="emisor[0][cuit]"  class="form-control input-lg emisor_cuit typeahead"  type="text" placeholder="CUIT">
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 clearfix">
                        <input id="emisor_razon_social" name="emisor[0][razon_social]"  class="form-control input-lg emisor_razon" type="text" placeholder="Razón Social">
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
                            <input  id="cheque_nro" name="emisor[0][cheque][0][nro]"  class="cheque_nro form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Nro">   
                        </div>
                        <div class="col-lg-4 col-md-2 col-sm-12">
                            <input id="cheque_banco" name="emisor[0][cheque][0][banco]"  class="cheque_banco  form-control input-lg typeahead" type="text" placeholder="Banco">   
                            <input id="cheque_banco_id" name="emisor[0][cheque][0][banco_id]" class="cheque_banco_id" type="hidden" >
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-12">
                            <input id="cheque_importe" name="emisor[0][cheque][0][importe]"  class="form-control input-lg cheque_importe text-right" type="text" placeholder="Importe $">   
                        </div>    
                    </div>
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Plazo :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="cheque_fecha" name="emisor[0][cheque][0][fecha]"  class="cheque_fecha form-control input-lg "  data-provide="datepicker" type="text" placeholder="Vencimiento">   
                        </div>  
                        <div class="col-lg-1 col-md-2 col-sm-12">
                            <input id="cheque_dias" name="emisor[0][cheque][0][dias]"  class="cheque_dia form-control input-lg "  type="text" placeholder="Días">   
                        </div> 
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Tasas :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="tasa_mensual" name="emisor[0][cheque][0][tasa_mensual]"  class="cheque_tasa_mensual form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Mensual" >   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="tasa_anual" name="emisor[0][cheque][0][tasa_anual]"  class="cheque_tasa_anual form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Anual">   
                        </div> 
                    </div>
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Interes :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="interes" name="emisor[0][cheque][0][interes]"  class="cheque_interes form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Cliente $">   
                        </div> 
                        <label for="emisor_cuit" class="col-lg-2 col-md-1 col-sm-12 control-label emisor ">Comisión :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="comision_porcentaje" name="emisor[0][cheque][0][comision_porcentaje]"  class="cheque_comision_porcentaje form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="%">   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="comision_importe" name="emisor[0][cheque][0][comision_importe]"  class="cheque_comision_importe form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="$">   
                        </div> 
                    </div>
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cobro Varios :</label>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="impuesto" name="emisor[0][cheque][0][impuesto]"  class="cheque_impuesto form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Impuesto Cheque">   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="gasto" name="emisor[0][cheque][0][gasto]"  class="cheque_gasto form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Gastos $">   
                        </div>                        
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="iva" name="emisor[0][cheque][0][iva]"  class="cheque_iva form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="IVA(21%)">   
                        </div> 
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <input id="sellado" name="emisor[0][cheque][0][sellado]"  class="cheque_sellado form-control input-lg typeahead" data-provide="typeahead" type="text" placeholder="Sellado">   
                        </div>
                    </div>                    
                    <div class="row">
                        <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Neto x Cheque :</label>
                        <div class="col-lg-3 col-md-2 col-sm-12">
                        <input id="neto_cheche" name="emisor[0][cheque][0][neto]"  class="cheque_neto form-control input-lg " type="text" placeholder="Neto x Cheque">   
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
    <div role="tabpanel" class="tab-pane" id="step2">
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Banco</th>
                            <th>Cheque Nro</th>
                            <th>Importe</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center">
                            <button class="btn btn-info btn-sm add_check_out "> <span class="icon-check-money"></span> Agregar Cheque</button>
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
            <button class="btn btn-info btn-sm add_tranfe_out "> <span class="icon-check-money"></span> Agregar Cheque</button>
            </div>
        </div>


    </div>
    <div role="tabpanel" class="tab-pane" id="step3">
        <div class="col-lg-12">
            <h2>Resumen:</h2>
        </div>
    </div>
  </div>


</form>

 <script src="<?php echo base_url('application/views/operations/form.js');?>"></script>
