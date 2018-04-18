<script>
function getFeriados(callback) {
    var data;
    $.ajax({
        type: "GET",
        url: 'feriado/getAll',
        data: {},
        async: false,
        success: function(resp) {
            data = resp;
            callback(data);
        },
        error: function() {},
        dataType: 'json'
    });
}

function getValores(callback) {
    var data;
    $.ajax({
        type: "GET",
        url: 'valuegral/getConfigValue',
        data: {},
        async: false,
        success: function(resp) {
            data = resp;
            callback(data);
        },
        error: function() {},
        dataType: 'json'
    });
}


function set_valores(valores) {
    //#TODO: CONTINUAR AQUI
    var _cheque_tasa_mensual = $(".emisor_section").find('.cheque_tasa_mensual');
    var _cheque_tasa_anual = $(".emisor_section").find('.cheque_tasa_anual');
    var _cheque_comision_porcentaje = $(".emisor_section").find('.cheque_comision_porcentaje');
    var _cheque_gasto = $(".emisor_section").find('.cheque_gasto');

    $.each(_cheque_tasa_mensual, function(index, item) {
        if ($(item).val() == '') {
            $(item).val(valores[0].tasa);
        }
    });
    $.each(_cheque_tasa_anual, function(index, item) {
        if ($(item).val() == '') {
            $(item).val((valores[0].tasa) * 12);
        }
    });

    $.each(_cheque_comision_porcentaje, function(index, item) {
        if ($(item).val() == '') {
            $(item).val(valores[0].comision);
        }
    });
    $.each(_cheque_gasto, function(index, item) {
        if ($(item).val() == '') {
            $(item).val(valores[0].gastos);
        }
    });

}

var form_operacion = function() {
    var tomador_data;
    var emisor_data = new Array();
    var cheques_ingreso = new Array();
    var neto_final = 0;
    var feriados = null;
    getFeriados(function(d) {
        feriados = d;
        return d;
    });

    var valores_gral = null;
    getValores(function(d) {
        valores_gral = d;
        return d;
    });
    set_valores(valores_gral)
    var bancos = null;
    //Inputs
    var tomador_cuit = $("#tomador_cuit");
    //$('.section_cheques .cheque_importe_in').maskMoney({ allowNegative: false, thousands: '.', decimal: ',', allowZero: true, prefix: '$' }); //.trigger('mask.maskMoney');


    var d = new Date();
    var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
    var _date_picker_data = {
        beforeShowDay: function(date) {
            var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [feriados.indexOf(datestring) == -1]
        },
        minDate: today,
        dateFormat: 'dd-mm-yy',
        setDate: today,
        onSelect: function(dateText, int) {
            var _input_dia = $(this).closest('.row').find('.cheque_dia');
            var fecha_venc = $(this).datepicker('getDate');
            var total_days = (fecha_venc - today) / (1000 * 60 * 60 * 24);

            switch (fecha_venc.getDay()) {
                case 4:
                case 5:
                case 6:
                    {
                        total_days += 4;
                        break;
                    }
                case 0:
                    {
                        total_days += 3;
                        break;
                    }
                case 4:
                    {
                        total_days += 2;
                        break;
                    }
                default:
                    {
                        total_days += 2;
                        break;
                    }
            }
            var newdate = new Date(today);
            newdate.setDate(newdate.getDate() + total_days);
            var i = 0;
            var add_day = 0;
            temp_date = new Date(newdate);
            do {
                if (jQuery.datepicker.formatDate('yy-mm-dd', temp_date) == feriados[i]) {
                    temp_date.setDate(temp_date.getDate() + 1);
                    total_days++;
                }
                i++;
            } while (i < feriados.length);
            fechaAcreditacion = jQuery.datepicker.formatDate('yy-mm-dd', newdate);
            newdate.setDate(newdate.getDate() + total_days);
            _input_dia.val(total_days).trigger('change');
        }
    }
    $("#cheque_fecha").datepicker(_date_picker_data);



    // actions
    tomador_cuit.typeahead({
        minLength: 2,
        items: 'all',
        showHintOnFocus: false,
        scrollHeight: 0,
        source: function(query, process) {
            var data_ajax = {
                type: "POST",
                url: 'agent/buscadorDeAgentes',
                data: { action: 'search', code: query, type: 'T' },
                success: function(data) {
                    
                    if (data == false) { 
                        $("#tomador_razo_social").val(null);    
                        $("#tomador_id").val(0);  
                        return false;                 
                        return process;
                    }else{
                        objects = [];
                        map = {};
                        $.each(data, function(i, object) {
                            if (object.razon_social != '') {
                                var key = object.cuit + " - " + object.razon_social;
                            } else {
                                var key = object.cuit + " - " + object.nombre + " " + object.apellido;
                            }
                            map[key] = object;
                            objects.push(key);
                        });
                        return process(objects);
                    }
                    
                },
                error: function(error_msg) {
                    alert("error_msg: " + error_msg);
                },
                dataType: 'json'
            };
            $.ajax(data_ajax);

        },
        updater: function(item) {
            var data = map[item];
            console.debug("===>  TOMADOR TYPEAHEAD: %o",data);
            $("#tomador_razo_social").val(null);
            $("#tomador_id").val(null);
            if (tomador_cuit.val().length == data.cuit.length && tomador_cuit.val() != data.cuit) {
                $("#tomador_razo_social").val(null);
                $("#tomador_id").val(0);
                tomador_data = {
                    id: -1,
                    cuit: tomador_cuit.val(),
                    nombre: null,
                    apellido: null,
                    razon_social: null,
                    domicilio: null
                };
                return tomador_cuit.val();
            } else {
                var value = (data.razon_social.lenght > 0) ? data.razon_social : data.nombre + " " + data.apellido
                $("#tomador_razo_social").val(value);
                $("#tomador_id").val(data.id);
                tomador_data = data;
                return data.cuit;
            }
        }
    });
    //AJAX emisor_section 

    $(".emisor_section").on('keyup', '.emisor_cuit', function() {

        var _this_emisor_ = $(this);
        var _emisor_id = $(this).closest('.row').find(".emisor_id");
        var _emisor_razon = $(this).closest('.row').find(".emisor_razon");

        $(this).typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                var data_ajax = {
                    type: "POST",
                    url: 'agent/buscadorDeAgentes',
                    data: { action: 'search', code: query, type: 'T' },
                    success: function(data) {
                        if (data == false) {
                            _emisor_id.val(null);
                            _emisor_razon.val(0);
                            return false;
                        }
                        objects = [];
                        map = {};
                        $.each(data, function(i, object) {
                            if (object.razon_social != '') {
                                var key = object.cuit + " - " + object.razon_social;
                            } else {
                                var key = object.cuit + " - " + object.nombre + " " + object.apellido;
                            }
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

            },
            updater: function(item) {

                var data = map[item];
                _emisor_id.val(null);
                _emisor_razon.val(null);

                if (_this_emisor_.val().length == data.cuit.length && _this_emisor_.val() != data.cuit) {
                    _emisor_id.val(null);
                    _emisor_razon.val(0);
                    temp_data = {
                        id: -1,
                        cuit: _this_emisor_.val(),
                        nombre: null,
                        apellido: null,
                        razon_social: null,
                        domicilio: null
                    };
                    emisor_data.push(temp_data);
                    return _this_emisor_.val();
                } else {
                    var value = (data.razon_social.lenght > 0) ? data.razon_social : data.nombre + " " + data.apellido
                    _emisor_razon.val(value);
                    _emisor_id.val(data.id);
                    emisor_data.push(data);
                    return data.cuit;
                }
            }
        });
    });
    //AGREGA EMISOR
    $(".emisor_section").on('click', '.bt_add_emisor', function() {

        var num_item = $(this).data('num_item');
        var output = '';

        output += '<div class="form-group op_valor_item" data-num="' + (num_item) + '"> ';
        output += '  <div class="row">';
        output += '     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor tag1">Emisor</label>';
        output += '     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '         <input id="emisor_cuit_' + num_item + '" name="emisor[' + num_item + '][cuit]"  class="emisor_cuit form-control input-lg typeahead"  type="text" placeholder="CUIT">';
        output += '     </div>';
        output += '     <div class="col-lg-5 col-md-6 col-sm-12 clearfix">';
        output += '         <input id="emisor_razo_social_' + num_item + '" name="emisor[' + num_item + '][razon_social]"  class="emisor_razon form-control input-lg" autocomplete="off" type="text" placeholder="Razón Social">';
        output += '     </div>';
        output += '     <input type="hidden" id="emisor_id_' + num_item + '" name="emisor[' + num_item + '][id]"   class="emisor_id" > ';
        output += '     <div class="col-lg-3 text-left" style="">';
        output += '         <button type="button" class="bt_delete_emisor btn btn-flat btn-danger"> <i class="fa fa-times"></i></button>';
        output += '     </div> ';
        output += '  </div>';

        output += '     <div class="row cheques_section">';
        output += '         <div class="row">';
        output += '                 <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cheque :</label>';
        output += '                  <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_nro_' + num_item + '" name="emisor[' + num_item + '][cheque][0][nro]"  class="cheque_nro form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Nro"> ';
        output += '                     </div>';
        output += '                     <div class="col-lg-4 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_banco_' + num_item + '" name="emisor[' + num_item + '][cheque][0][banco]"  class="cheque_banco   form-control input-lg"  type="text" placeholder="Banco"> ';
        output += '                         <input id="cheque_banco_id_' + num_item + '" name="emisor[' + num_item + '][cheque][0][banco_id]" class="cheque_banco_id" type="hidden" > ';
        output += '                     </div>';
        output += '                     <div class="col-lg-3 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_importe" name="emisor[' + num_item + '][cheque][0][importe]"  class="form-control input-lg cheque_importe text-right"  type="text" placeholder="Importe $">';
        output += '                     </div> ';
        output += '                 </div> ';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Tasas :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_fecha_' + num_item + '" data-provide="datepicker" name="emisor[' + num_item + '][cheque][0][fecha]"  class="cheque_fecha form-control input-lg "  type="text" placeholder="Vencimiento">';
        output += '                     </div>  ';
        output += '                     <div class="col-lg-1 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_dias_' + num_item + '" name="emisor[' + num_item + '][cheque][0][dias]"  class="cheque_dia form-control input-lg " autocomplete="off" type="text" placeholder="Días">  ';
        output += '                     </div> ';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Plazo :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="tasa_mensual_' + num_item + '" name="emisor[' + num_item + '][cheque][0][tasa_mensual]"  class="cheque_tasa_mensual form-control input-lg "  type="text" placeholder="Mensual">  ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="tasa_anual_' + num_item + '" name="emisor[' + num_item + '][cheque][0][tasa_anual]"  class="cheque_tasa_anual form-control input-lg " autocomplete="off" type="text" placeholder="Anual">  ';
        output += '                     </div> ';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Interes :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="interes_' + num_item + '" name="emisor[' + num_item + '][cheque][0][interes]"  class="cheque_interes form-control input-lg " data-provide="" autocomplete="off" type="text" placeholder="Cliente $">  ';
        output += '                     </div> ';
        output += '                     <label for="emisor_cuit" class="col-lg-2 col-md-1 col-sm-12 control-label emisor ">Interes :</label>';
        output += '                     <div class="col-lg-1 col-md-2 col-sm-12">';
        output += '                         <input id="comision_porcentaje_' + num_item + '" name="emisor[' + num_item + '][cheque][0][comision_porcentaje]"  class="cheque_comision_porcentaje cheque_comision_porcentaje form-control input-lg "  type="text" placeholder="%"> ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-1 col-md-2 col-sm-12">';
        output += '                         <input id="comision_importe_' + num_item + '" name="emisor[' + num_item + '][cheque][0][comision_importe]"  class="cheque_comision_importe form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="$">  ';
        output += '                     </div> ';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cobro Varios :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="impuesto_' + num_item + '" name="emisor[' + num_item + '][cheque][0][impuesto]"  class="cheque_impuesto form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Impuesto Cheque"> ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="gasto_' + num_item + '" name="emisor[' + num_item + '][cheque][0][gasto]"  class="cheque_gasto form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Gastos $"> ';
        output += '                     </div>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="iva_' + num_item + '" name="emisor[' + num_item + '][cheque][0][iva]"  class="cheque_iva form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="IVA(21%)"> ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="sellado_' + num_item + '" name="emisor[' + num_item + '][cheque][0][sellado]"  class="cheque_sellado form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Sellado">   ';
        output += '                     </div>';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Neto x Cheque :</label>';
        output += '                     <div class="col-lg-3 col-md-2 col-sm-12">';
        output += '                         <input id="neto_cheche_' + num_item + '" name="emisor[' + num_item + '][cheque][0][neto]"  class="cheque_neto form-control input-lg typeahead" data-provide="typeahead" autocomplete="off" type="text" placeholder="Neto x Cheque">';
        output += '                         <input id="compra_' + num_item + '" name="emisor[' + num_item + '][cheque][0][compra]"  class="cheque_compra " type="hidden" >';
        output += '                     </div> ';
        output += '                 </div>';
        output += '                 <div class="col-lg-12  text-right" style="">       ';
        output += '                      <button type="button" class="btn_add_cheque btn btn-flat btn-success" data-num="0"> <i class="fa fa-plus"></i>Cheque</button>';
        output += '                 </div>';
        output += '         </div>';
        output += '</div>';


        $(".emisor_section").append(output);
        $(".emisor_section").find("op_valor_item:last").focus();

        $('.cheque_importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });

        $(this).data('num_item', num_item + 1);
        $('.cheque_fecha').datepicker(_date_picker_data);
        set_valores(valores_gral);
        return false;
    });
    //DELETE EMISOR
    $(".emisor_section").on('click', '.bt_delete_emisor', function() {
        $(this).closest(".op_valor_item").remove();
        return false;
    });


    //ADD CHEQUE
    $(".emisor_section").on('click', '.btn_add_cheque', function() {
        var num_item = $(this).data('num');
        var _op_valor_item = $(this).closest('.op_valor_item');
        var _nro_emisor = _op_valor_item.data('num');
        var _nro_cheque = (num_item == 0) ? 1 : num_item;
        var output = '';
        output += '     <div class="row cheques_section">';
        output += '         <div class="row">';
        output += '                 <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cheque :</label>';
        output += '                  <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_nro' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][nro]"  class="cheque_nro form-control input-lg"  type="text" placeholder="Nro"> ';
        output += '                     </div>';
        output += '                     <div class="col-lg-4 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_banco' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][banco]"  class="cheque_banco form-control input-lg typeahead"  type="text" placeholder="Banco"> ';
        output += '                         <input id="cheque_banco_id' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][banco_id]" class="cheque_banco_id"  type="hidden" >';
        output += '                     </div>';
        output += '                     <div class="col-lg-3 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_importe' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][importe]"  class="form-control input-lg cheque_importe text-right"  type="text" placeholder="Importe $">';
        output += '                     </div> ';
        output += '                     <div class="col-lg-1 text-left" style="">';
        output += '                         <button type="button" class="bt_delete_cheque btn btn-flat btn-danger"> <i class="fa fa-times"></i></button>';
        output += '                     </div> ';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Tasas :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_fecha' + _nro_cheque + '" data-provide="datepicker" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][fecha]"  class="cheque_fecha form-control input-lg "  type="text" placeholder="Vencimiento">';
        output += '                     </div>  ';
        output += '                     <div class="col-lg-1 col-md-2 col-sm-12">';
        output += '                         <input id="cheque_dias' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][dias]"  class=" cheque_dia form-control input-lg "  type="text" placeholder="Días">  ';
        output += '                     </div> ';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Plazo :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="tasa_mensual' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][tasa_mensual]"  class="cheque_tasa_mensual form-control input-lg "  type="text" placeholder="Mensual">  ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="tasa_anual' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][tasa_anual]"  class="cheque_tasa_anual form-control input-lg "  type="text" placeholder="Anual">  ';
        output += '                     </div> ';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Interes :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="interes' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][interes]"  class="cheque_interes form-control input-lg "  type="text" placeholder="Cliente $">  ';
        output += '                     </div> ';
        output += '                     <label for="emisor_cuit" class="col-lg-2 col-md-1 col-sm-12 control-label emisor ">Interes :</label>';
        output += '                     <div class="col-lg-1 col-md-2 col-sm-12">';
        output += '                         <input id="comision_porcentaje' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][comision_porcentaje]"  class="cheque_comision_porcentaje form-control input-lg "  type="text" placeholder="%"> ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-1 col-md-2 col-sm-12">';
        output += '                         <input id="comision_importe' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][comision_importe]"  class="cheque_comision_importe form-control input-lg "  type="text" placeholder="$">  ';
        output += '                     </div> ';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Cobro Varios :</label>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="impuesto' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][impuesto]"  class="cheque_impuesto form-control input-lg "  type="text" placeholder="Impuesto Cheque"> ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="gasto' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][gasto]"  class="cheque_gasto form-control input-lg "  type="text" placeholder="Gastos $"> ';
        output += '                     </div>';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="iva' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][iva]"  class="cheque_iva form-control input-lg " autocomplete="off" type="text" placeholder="IVA(21%)"> ';
        output += '                     </div> ';
        output += '                     <div class="col-lg-2 col-md-2 col-sm-12">';
        output += '                         <input id="sellado' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][sellado]"  class="cheque_sellado form-control input-lg " autocomplete="off" type="text" placeholder="Sellado">   ';
        output += '                     </div>';
        output += '                 </div>';
        output += '                 <div class="row">';
        output += '                     <label for="emisor_cuit" class="col-lg-1 col-md-1 col-sm-12 control-label emisor ">Neto x Cheque :</label>';
        output += '                     <div class="col-lg-3 col-md-2 col-sm-12">';
        output += '                         <input id="neto_cheche' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][neto]"  class="cheque_neto form-control input-lg " autocomplete="off" type="text" placeholder="Neto x Cheque">';
        output += '                         <input id="compra_' + _nro_cheque + '" name="emisor[' + _nro_emisor + '][cheque][' + _nro_cheque + '][compra]"  class="cheque_compra " type="hidden" >';
        output += '                     </div> ';
        output += '                 </div>';

        output += '     </div>';
        $(this).closest('.op_valor_item').append(output);
        $(this).data('num', _nro_cheque + 1);
        $('.cheque_importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });
        $('.cheque_fecha').datepicker(_date_picker_data);
        set_valores(valores_gral);
        return false;
    });

    //$('.')bt_delete_cheque 
    //DELETE CHEQUE
    $(".emisor_section").on('click', '.bt_delete_cheque', function() {
        $(this).closest(".cheques_section").remove();
        return false;
    });


    $(".emisor_section").on('change', '.cheque_importe ', function() {


        var _div_parent = $(this).closest('.cheques_section');
        var _importe = ($(this).val().length > 1) ? parseFloat($(this).val()) : 0;
        var _dias = (_div_parent.find(".cheque_dia").val().length > 0) ? parseFloat(_div_parent.find(".cheque_dia").val()) : 1;
        var _cheque_tasa_mensual = (_div_parent.find(".cheque_tasa_mensual").val() != '') ? parseFloat(_div_parent.find(".cheque_tasa_mensual").val()) : 0;
        var _cheque_tasa_anuall = (_div_parent.find(".cheque_tasa_anual").val() != '') ? parseFloat(_div_parent.find(".cheque_tasa_anual").val()) : 0;
        var _cheque_comision_porcentaje = (_div_parent.find(".cheque_tasa_anual").val() != '') ? parseFloat(_div_parent.find(".cheque_comision_porcentaje").val()) : 0;
        var _cheque_comision_importe = (_div_parent.find(".cheque_tasa_anual").val() != '') ? parseFloat(_div_parent.find(".cheque_comision_importe").val()) : 0;
        var _cheque_gasto = (_div_parent.find(".cheque_gasto").val() != '') ? parseFloat(_div_parent.find(".cheque_gasto").val()) : 0;

        var _interes = _importe * (_cheque_tasa_anuall / 365) * (_dias / 100);
        _div_parent.find(".cheque_interes").val(_interes.toFixed(2));

        var _comision_importe = _importe * (parseFloat(_cheque_comision_porcentaje) / 100);
        _div_parent.find(".cheque_comision_importe").val(_comision_importe.toFixed(2));

        var _impuesto_cheque = _importe * (parseFloat(1.2) / 100);
        _div_parent.find('.cheque_impuesto').val(_impuesto_cheque.toFixed(2));

        var _iva = (parseFloat(_interes) + parseFloat(_comision_importe)) * (21 / 100);
        _div_parent.find('.cheque_iva').val(_iva.toFixed(2));

        var _sellado = (_importe * (0.5 / 100)) + (_importe * (0.5 / 100) * (20 / 100)) + (_importe * (0.5 / 100) * (20 / 100));
        _div_parent.find('.cheque_sellado').val(_sellado.toFixed(2));

        var _compra = _importe - _interes - _impuesto_cheque - _cheque_gasto;
        var _neto_parcial = _compra - _comision_importe;
        console.debug("====> _neto_parcial: %o",_neto_parcial);
        var _neto = _neto_parcial - _iva - _sellado;
        console.debug("====> _neto: %o",_neto);
        
        _div_parent.find('.cheque_compra').val(_compra.toFixed(2));
        _div_parent.find('.cheque_neto').val(_neto.toFixed(2));
        _div_parent.find('.cheque_neto').trigger('change');
       
        //$('.neto_span').html("$ " + _neto.toFixed(2));

    })

    $(".emisor_section").on('change', '.cheque_dia', function() {
        var today = new Date();
        if($(this).val()!=''){
            var days = $(this).val();
            today.setDate(today.getDate() + parseInt(days));  
            if (today.getDay() == 1) {
                today.setDate(today.getDate() - 4);
            } else if (today.getDay() == 2) {
                today.setDate(today.getDate() - 4);
            } else {
                today.setDate(today.getDate() - 2);
            }
        }
        var mes = today.getMonth() + 1;
        var _div_parent = $(this).closest('.cheques_section');
        _div_parent.find('.cheque_fecha').val(today.getDate() + '-' + mes + '-' + today.getFullYear());
        _div_parent.find('.cheque_importe').trigger('change');
    });

    $(".emisor_section").on('change', '.cheque_tasa_mensual', function() {
        console.debug("===> cheque_tasa_mensual: %o ",$(this).val());
        $(this).closest('.cheques_section').find('.cheque_importe').trigger('change');  
    });


    $(".emisor_section").on('change', '.cheque_neto', function() {
        console.log("Cheque_neto change")
        var neto_total = 0;
        $.each($(".emisor_section").find('.cheque_neto'), function(index, item) {
            neto_total += parseFloat($(item).val());
        });
        $("#neto_final").val(neto_total.toFixed(2));
        neto_final = neto_total.toFixed(2);
        console.debug("====> neto_final: %o",neto_final);
        $('.neto_span').html("$ " + neto_total.toFixed(2));
    });


    $(".emisor_section").on('keyup', '.cheque_banco', function() {
        var _cheque_banco_id = $(this).closest('.row').find(".cheque_banco_id");
        $(this).typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                var data_ajax = {
                    type: "POST",
                    url: 'bank/buscadorDeBancos',
                    data: { action: 'search', code: query, type: 'E' },
                    success: function(data) {
                        if (data == false) {
                            return false;
                        }
                        objects = [];
                        map = {};
                        $.each(data, function(i, object) {
                            if (object.sucursal != '') {
                                var key = object.razon_social + ' - ' + object.sucursal;
                            } else {
                                var key = object.razon_social;
                            }
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
            },
            updater: function(item) {
                var data = map[item];
                _cheque_banco_id.val(data.id);
                return data.razon_social;
            }
        });
    });


    $('.add_check_out').click(function() {
        console.log("=====> add_check_out clicked");
        var _table = $(this).closest('table');
        var num_items = ($(this).data('num_item') !== undefined) ? $(this).data('num_item') : 0;

        var out_put = "";
        out_put += '<tr>';
        out_put += '<td><input id="cheque_salida_banco' + num_items + '" name="cheque_salida[' + num_items + '][banco]"  class="cheque_salida_banco form-control input-lg typeahead" autocomplete="off" type="text" placeholder="Banco">';
        out_put += '<input id="cheque_salida_banco' + num_items + '" name="cheque_salida[' + num_items + '][banco_id]"  class="cheque_salida_banco_id" type="hidden"></td>';
        out_put += '<td><input id="cheque_salida_nro_' + num_items + '" name="cheque_salida[' + num_items + '][nro]"  class="cheque_salida_nro form-control input-lg " autocomplete="off" type="text" placeholder="Nro"></td>';
        out_put += '<td><input id="cheque_salida_importe_' + num_items + '" name="cheque_salida[' + num_items + '][importe]"  class="cheque_salida_importe form-control input-lg " autocomplete="off" type="text" placeholder="Importe"></td>';
        out_put += '<td><input id="cheque_salida_fecha_' + num_items + '" name="cheque_salida[' + num_items + '][fecha]"  class="cheque_salida_fecha form-control input-lg " autocomplete="off" type="text" placeholder="Fecha"></td>';

        out_put += '<td><button type="button" class="bt_cheque_out_delete btn btn-flat btn-danger"> <i class="fa fa-times"></i></button></td>';
        out_put += '</tr>';
        _table.find("tbody").append(out_put);
        $(this).data('num_item', num_items + 1);
        $('.cheque_salida_importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });

        return false;
    });

    $('.table_cheque').on('click', '.cheque_salida_fecha', function() {
        $(this).datepicker({
            minDate: today,
            dateFormat: 'dd-mm-yy',
            setDate: today,
        });

    });

    $('.table_cheque').on('keyup', '.cheque_salida_banco', function() {
        var _cheque_salida_banco_id = $(this).closest('tr').find(".cheque_salida_banco_id");
        console.log("=====> _cheque_salida_banco_id clicked");
        $(this).typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                var data_ajax = {
                    type: "POST",
                    url: 'bank/buscadorDeBancos',
                    data: { action: 'search', code: query, type: 'E' },
                    success: function(data) {
                        if (data == false) {
                            return false;
                        }
                        objects = [];
                        map = {};
                        $.each(data, function(i, object) {
                            if (object.sucursal != '') {
                                var key = object.razon_social + ' - ' + object.sucursal;
                            } else {
                                var key = object.razon_social;
                            }
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
            },
            updater: function(item) {
                var data = map[item];
                _cheque_salida_banco_id.val(data.id);
                return data.razon_social;
            }
        });

    });

    $('.table_cheque').on('click', '.bt_cheque_out_delete', function() {
        console.log("=====> bt_cheque_out_delete clicked");
        $(this).closest('tr').remove();
        return false;
    });

    $('.add_tranfe_out').click(function() {
        console.log("=====> add_tranfe_out clicked");
        var _table = $(this).closest('table');
        var num_items = ($(this).data('num_item') !== undefined) ? $(this).data('num_item') : 0;
        var out_put = "";
        out_put += '<tr>';

        out_put += '<td><input id="transferencia_salida_banco' + num_items + '" name="transferencia_salida[' + num_items + '][banco]"  class="transferencia_salida_banco form-control input-lg typeahead" autocomplete="off" autocomplete="off" type="text" placeholder="Banco">';
        out_put += '<input id="transferencia_salida_banco' + num_items + '" name="transferencia_salida[' + num_items + '][banco_id]"  class="transferencia_salida_banco_id" type="hidden"></td>';
        out_put += '<td><input id="transferencia_salida_cbu_' + num_items + '" name="transferencia_salida[' + num_items + '][cbu]"  class="transferencia_salida_cbu form-control input-lg " autocomplete="off" autocomplete="off" type="text" placeholder="Nro"></td>';
        out_put += '<td><input id="transferencia_salida_importe_' + num_items + '" name="transferencia_salida[' + num_items + '][importe]"  class="transferencia_salida_import form-control input-lg " autocomplete="off" autocomplete="off" type="text" placeholder="Importe"></td>';
        out_put += '<td><input id="transferenciae_salida_fecha_' + num_items + '" name="transferencia_salida[' + num_items + '][fecha]"  class="transferencia_salida_fecha form-control input-lg " autocomplete="off" autocomplete="off" type="text" placeholder="Fecha"></td>';

        out_put += '<td><button type="button" class="bt_transfer_out_delete btn btn-flat btn-danger"> <i class="fa fa-times"></i></button></td>';

        out_put += '</tr>';
        _table.find("tbody").append(out_put);
        $(this).data('num_item', num_items + 1);
        $('.transferencia_salida_import').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });

        return false;
    });

    $('.table_tranfer').on('click', '.transferencia_salida_fecha', function() {
        $(this).datepicker({
            minDate: today,
            dateFormat: 'dd-mm-yy',
            setDate: today,
        });

    });

    $('.table_tranfer').on('click', '.bt_transfer_out_delete', function() {
        console.log("=====> bt_transfer_out_delete clicked");
        $(this).closest('tr').remove();
        return false;
    });

    $('.table_tranfer').on('keyup', '.transferencia_salida_banco', function() {
        var _transferencia_salida_banco_id = $(this).closest('tr').find(".transferencia_salida_banco_id");
        console.log("=====> _transferencia_salida_banco_id clicked");
        $(this).typeahead({
            minLength: 3,
            items: 'all',
            showHintOnFocus: false,
            scrollHeight: 0,
            source: function(query, process) {
                var data_ajax = {
                    type: "POST",
                    url: 'bank/buscadorDeBancos',
                    data: { action: 'search', code: query, type: 'E' },
                    success: function(data) {
                        if (data == false) {
                            return false;
                        }
                        objects = [];
                        map = {};
                        $.each(data, function(i, object) {
                            if (object.sucursal != '') {
                                var key = object.razon_social + ' - ' + object.sucursal;
                            } else {
                                var key = object.razon_social;
                            }
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
            },
            updater: function(item) {
                var data = map[item];
                _transferencia_salida_banco_id.val(data.id);
                return data.razon_social;
            }
        });

    });


    $("#step2").on('change', '.cheque_salida_importe, .transferencia_salida_import', function() {

        var _importes_cheque = $("#step2").find('.cheque_salida_importe');
        var _importes_tranferencia = $("#step2").find('.transferencia_salida_import');
        var pago_final = 0;
        $.each(_importes_cheque, function(index, item) {
            console.log($(item).val());
            pago_final += parseFloat($(item).val());
        });
        $.each(_importes_tranferencia, function(index, item) {
            console.log($(item).val());
            pago_final += parseFloat($(item).val());
        });
        $(".neto_total_final").removeClass('text-red');
        $(".neto_total_final").removeClass('text-light-blue');
        $(".aler_tope").hide();
        if (pago_final > neto_final) {
            $(".neto_total_final").text("$ " + pago_final.toFixed(2)).addClass("text-red");
            $(".aler_tope").show();
        } else {
            $(".neto_total_final").text("$ " + pago_final.toFixed(2)).addClass('text-light-blue');
        }
        return false;
    });

    //Declara funcionalidad plugins:
    $('.cheque_salida_importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });
    $('.transferencia_salida_import').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });
    $('.cheque_importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' });


    
    var validate_step_1 = function() {

        
        var _inputs = $("#step1").find("input");
        var validate_ok=true;
        $.each(_inputs, function(index, item) {
            if ($(item).val().length == 0) {
                alert("Debe completetar un campo");
                $(item).focus();
                validate_ok=false;
                return false;
            }
        });
        
        if( !validate_ok ){
            return false;
        }

        console.log("==== > validate_step_1 < ====");
        var _cheques = new Array();
        var _totales_importes = 0;
        var _totales_interes = 0;
        var _totales_impuestos = 0;
        var _totales_otros = 0;
        var _totales_comision = 0;
        var _totales_iva = 0;
        var _totales_sellado = 0;
        var _totales_neto_liquidacion = 0;

        var _op_valor_item = $("#step1").find('.op_valor_item');        
        var _tabla_output='';

        if(tomador_data===undefined){
            alert("No se ha seleccionado correctamente un Tomador. Por Favor, vuelva a intentarlo.");
            $("#tomador_cuit").focus();
            return false;
        }
        console.log(tomador_data);
        
        $('.cliente_nombre').text( (tomador_data.razon_social!='')? tomador_data.razon_social: tomador_data.nombre+' '+tomador_data.apellido  );
        $('.cliente_domicilio').text(tomador_data.domicilio);
        $('.cliente_cuit').text(tomador_data.cuit);


        $.each(_op_valor_item,function(index, item){

            var _cheques_section = $(item).find('.cheques_section');           

            $.each(_cheques_section, function(sindex,sitem){          

                // Calcula valores a Liquidar INICIO
                _totales_importes += parseFloat( $(sitem).find('.cheque_importe').val());
                _totales_interes += parseFloat( $(sitem).find('.cheque_interes').val());
                _totales_impuestos += parseFloat( $(sitem).find('.cheque_impuesto').val());
                _totales_otros += parseFloat( $(sitem).find('.cheque_gasto').val());
                _totales_comision += parseFloat( $(sitem).find('.cheque_comision_importe').val());
                _totales_iva += parseFloat( $(sitem).find('.cheque_iva').val());
                _totales_sellado += parseFloat( $(sitem).find('.cheque_sellado').val());
                _totales_neto_liquidacion += parseFloat( $(sitem).find('.cheque_neto').val());
                // Calcula valores a Liquidar FIN
                
                _tabla_output += '<tr>'; 
                _tabla_output += '<td class="text-center"> '+$(sitem).find('.cheque_banco').val()+' </td>';                
                _tabla_output += '<td class="text-center"> '+$(sitem).find('.cheque_nro').val()  +' </td>';
                _tabla_output += '<td class="text-center"> '+$(item).find('.emisor_razon').val() +' </td>';
                _tabla_output += '<td class="text-center"> '+$(sitem).find('.cheque_fecha').val()+' </td>';
                _tabla_output += '<td class="text-center"> '+$(sitem).find('.cheque_tasa_mensual').val()+' </td>';
                _tabla_output += '<td class="text-center"> '+$(sitem).find('.cheque_dia').val()+' </td>';
                _tabla_output += '<td class="td_detail"> '+$(sitem).find('.cheque_importe').val()+' </td>';
                _tabla_output += '</tr>';            

            }); 
            
           
        });

        _tabla_output += '<tr> <td colspan=7 > </td></tr>';

        $('#table_cheque_final').find('tbody.main').html(_tabla_output);

        var _tabla_output2 ='';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">Total Valores $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_importes.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">Interes $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_interes.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">Imp Deb y Cred Bancario $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_impuestos.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">Valores otra Plaza $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_otros.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">Comisiones $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_comision.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">IVA $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_iva.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">SELLADO $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_sellado.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';
            _tabla_output2+='<tr>';
            _tabla_output2+='   <td colspan=6 class="text-right">Total Valores $</td>';
            _tabla_output2+='   <td class="td_detail">'+_totales_neto_liquidacion.toFixed(2)+'</td>';
            _tabla_output2+='</tr>';

        $('#table_cheque_final').find('tbody.secundary').html(_tabla_output2);


        return true;
    }

    var validate_step_2 = function() {
        console.log("====> validate_step_2");
        var _inputs_cheque = $("table.table_cheque").find("input.cheque_salida_banco");
        var _inputs_tranferencia = $("table.table_tranfer").find("input.transferencia_salida_banco");
        if (_inputs_cheque.length == 0 && _inputs_tranferencia.length == 0) {
            alert(" No se ha creado cheques ni transferencia. Por Favor, vuelva a intentar!");
            return false;
        }


        var _inputs = $("table.table_cheque").find("input");
        $.each(_inputs, function(index, item) {
            if ($(item).val().length == 0) {
                alert("Debe completetar un campo");
                return false;
            }
        });

        var _inputs = $("table.table_tranfer").find("input");
        $.each(_inputs, function(index, item) {
            if ($(item).val().length == 0) {
                alert("Debe completetar un campo");
                return false;
            }
        });


        return true;
    }

    var print_liquidacion = function() {
        console.log("==== >print_liquidacion");
        var _op_valor_item = $('.emisor_section').find('.op_valor_item');
        console.debug("====> _op_valor_item: %o", _op_valor_item.length);

        return false;
    };
    $("#btnNext1").click(function() {
        //Tabula las pestañas
        var tab_index = $('.nav-tabs > li.active').index();
        if(tab_index==1){
            $(this).hide();
            $("#btnSave").removeClass('hidden');
            
        }
        $("#btnBack1").removeClass('hidden');
       
              
        

        switch (tab_index) {
            case 0:
                {
                    //validate_step_1();

                    if (validate_step_1()) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        ////back1_tb.removeClass("hidden");
                    } else {
                        return false;
                    }
                    $(this).removeClass("hidden");
                    //return false;
                    break;
                }
            case 1:
                {
                    if (validate_step_2()) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        //$(this).addClass("hidden");
                        //back1_tb.removeClass("hidden");
                        //save_tb.removeClass("hidden");
                    } else {
                        return false;
                    }
                    break;
                }
            case 2:
                {
                    //$(this).addClass("hidden");
                    //print_liquidacion();
                    return false;
                    back1_tb.removeClass("hidden");
                    break;
                }
            default:
                {
                    break;
                }
        }

    });

    $("#btnBack1").click(function() {

        var tab_index = $('.nav-tabs > li.active').index();
        $("#btnNext1").show();   
        $("#btnSave").addClass('hidden');    
        if(tab_index==1){
            $("#btnBack1").addClass('hidden');
        }
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');

    });
    /*
    $("#btnNext1").click(function() {
        var form_data = $("form").serialize();
        $.ajax({
            type: 'POST',
            data: $("form").serialize(),
            url: 'index.php/operation/addOperation/teds',
            success: function(result) {
                WaitingClose();
                $('#modalInversor').modal('hide');
                setTimeout("cargarView('operation', 'index', '" + $('#permission').val() + "');", 1000);
            },
            error: function(result) {
                WaitingClose();
                // alert("error");
            },
            dataType: 'json'
        });
        return false;
    });
     */


    $("#btnSave").click(function() {
        var form_data = $("form").serialize();
        console.debug("===> Form data: %o", form_data);
        //return false;
        //WaitingOpen();
        $.ajax({
            type: 'POST',
            data: $("form").serialize(),
            url: 'index.php/operation/addOperation/teds',
            success: function(result) {
                WaitingClose();
                $('#modalOperacion').modal('hide');
                setTimeout("cargarView('operation', 'index', '" + $('#permission').val() + "');", 1000);
            },
            error: function(result) {
                WaitingClose();
                // alert("error");
            },
            dataType: 'json'
        });
        return false;
    });

};




$(function() {
    form_operacion();
});
</script>