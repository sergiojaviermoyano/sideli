var operation = operationClass;
var emisor_data = {
    id: -1,
    cuit: '',
    nombre: '',
    apellido: '',
    razon_social: '',
    domicilio: ''
};
var tomador_data = {
    id: -1,
    cuit: '',
    nombre: '',
    apellido: '',
    razon_social: '',
    domicilio: ''
};
var banco_1 = {
    banco_id: 0,
    nombre: ''
};


$(function() {
    console.debug("=====> OPERATION JS FILE LOAD <=====");
    var feriados_field = $("#feriados_field").val();

    var feriados = feriados_field.split(',');
    console.log(feriados);

    var emisor_cuit_input = $(this).find("input#operationEmisorCuit");
    var tenedor_cuit_input = $(this).find("input#operationTomadorCuit");
    var banco_input = $(this).find("input#operationBanco");
    /**/
    var cheque_nro = $(this).find("#operationChequeNro");
    /**/
    var importe_input = $(this).find("input#operationImporte");
    /**/
    var fecha_vencimiento = $(this).find("input#operationFechaVen");
    /**/
    var dias_input = $(this).find("input#operationDias");
    /**/
    var tasa_mensual_input = $(this).find("input#opterationTasaMensual");
    /**/
    var tasa_anual_input = $(this).find("input#opterationTasaAnual");
    /**/
    var interes_input = $(this).find("input#opterationInteres");
    /**/
    var comision_input = $(this).find("input#opterationComision");
    /**/
    var comision_total_input = $(this).find("input#opterationComisionTotal");
    /**/
    var impuesto_cheque_input = $(this).find("input#operationImpuestoCheque");
    /**/
    var gasto_input = $(this).find("input#operationGasto");
    /**/
    var iva_input = $(this).find("input#operationIva");
    /**/
    var sellado_input = $(this).find("input#operationSellado");
    var compra_input = $(this).find("input#operationCompra");
    var subtotal_input = $(this).find("input#operationSubtotal");
    var neto_input = $(this).find("input#operationNeto");
    var step1_tb = $(this).find("button#btnNext1");
    var back1_tb = $(this).find("button#btnBack1");
    var save_tb = $(this).find("button#btnSave");
    var cheque_salida_nro = $(this).find("button#operationCheckOutNro");
    var cheque_salida_importe = $(this).find("button#operationCheckOutImporte");
    var cheque_salida_fecha = $(this).find("button#operationCheckOutFecha");
    var add_cheque_salida_bt = $(this).find("button.add_check_out");
    var add_tranfer_salida_tb = $(this).find("button.add_tranfer_out");

    var neto_total = 0;
    var total_valores_pagar = 0;
    var cliente_data = null;

    var calcular_valores = function() {
        //Esta funcion calcula todos los valores del formulario principal
        //console.debug("====>> calcular_valores ");
        //console.debug("\n==> Importe: %o",importe_input.val());
        operation.cheque.nro = cheque_nro.val();
        operation.cheque.dias = dias_input.val();
        operation.cheque.vencimiento = fecha_vencimiento.val();

        var cheques_entrada_importes = $('.section_cheques').find('.cheque_importe_in');

        console.debug("===>cheques_entrada_importes: %o", cheques_entrada_importes.length);

        //operation.cheque.importe = parseFloat(importe_input.val());
        operation.cheque.importe = 0;
        //debugger;
        cheques_entrada_importes.each(function(index, item) {

            if ($(item).val().length > 0) {
                console.debug("====> cheques_entrada_importes[ %o ]: %o", index, $(item).val());
                console.debug("====> cheques_entrada_importes: %o", parseFloat($(item).val().replace('$', '')));
                //console.debug("===> test: %o", parseFloatOpts($(item).val().replace('$', '')));
                var_cheque_importe_temp = $(item).val().replace('$', '');
                console.debug("===> test: %o", var_cheque_importe_temp);
                var_cheque_importe_temp = var_cheque_importe_temp.replace('.', '');
                console.debug("===> test: %o", var_cheque_importe_temp);
                console.debug("\n\n\n");
                operation.cheque.importe += parseFloat(var_cheque_importe_temp);
            }

        });

        console.debug("===>operation.cheque.importe: %o", operation.cheque.importe);
        //return false;


        //operation.cheque.importe = parseFloat(importe_input.val());
        //var cantDias=dias_input.val();            
        //var importe=parseFloat(importe_input.val());
        operation.tasaA = parseFloat(tasa_anual_input.val());
        operation.tasaM = parseFloat(tasa_mensual_input.val());
        //var tAnual=parseFloat(tasa_anual_input.val());
        operation.interesCliente = parseFloat(interes_input.val());
        operation.comisionPor = parseFloat(comision_input.val().replace(',', '.'));
        operation.comisionImp = parseFloat(comision_total_input.val().replace(',', '.'));
        //var comision=parseFloat(comision_input.val().replace(',','.'));
        operation.impuestoCheque = parseFloat('1.2'); //parseFloat(impuesto_cheque_input.data('valor').replace(',','.'));
        //console.de
        //var impuesto=parseFloat(impuesto_cheque_input.data('valor').replace(',','.'));
        //console.debug("====> aca_: %o",gasto_input.val());
        operation.gastos = (gasto_input.val() != '') ? parseFloat(gasto_input.val().replace(',', '.')) : 0;
        //var gastos=parseFloat(gasto_input.val().replace(',','.'));
        operation.importeIVA = parseFloat(iva_input.val().replace(',', '.'));
        //var iva=parseFloat(iva_input.val().replace(',','.'));
        operation.importeSellado = parseFloat(sellado_input.val().replace(',', '.'));
        //var sellado=parseFloat(sellado_input.val().replace(',','.'));


        var interes = operation.cheque.importe * (operation.tasaA / 365) * (operation.cheque.dias / 100);
        operation.interes = interes;

        //console.debug("\n==> Interes: %o",interes);
        interes_input.val(interes.toFixed(2));
        operation.comisionImp = operation.cheque.importe.toFixed(2) * operation.comisionPor / 100;
        //console.debug("==> comision_total: %o",operation.comisionImp);
        comision_total_input.val(operation.comisionImp.toFixed(2));
        operation.impuestoCheque = (operation.cheque.importe * operation.impuestoCheque) / 100;
        console.debug("==> impuesto_cheque: %o", operation.impuestoCheque);
        impuesto_cheque_input.val(operation.impuestoCheque.toFixed(2));
        var compra = operation.cheque.importe - interes - operation.impuestoCheque - operation.gastos;
        //console.debug("==> compra: %o",compra);
        var neto1 = compra - operation.comisionImp;
        //console.debug("==> neto1: %o",neto1);           
        operation.importeIVA = (interes + operation.comisionImp) * (21 / 100); //!!!!! (iva/100 )
        iva_input.val(operation.importeIVA.toFixed(2));
        //console.debug("==> iva_total: %o",operation.importeIVA);
        operation.importeSellado = (operation.cheque.importe * (0.5 / 100)) + (operation.cheque.importe * (0.5 / 100) * (20 / 100)) + (operation.cheque.importe * (0.5 / 100) * (20 / 100));
        //console.debug("==> sellado: %o",operation.importeSellado);
        sellado_input.val(operation.importeSellado.toFixed(2));
        var neto_final = neto1 - operation.importeIVA - operation.importeSellado;
        //console.debug("==> neto_final: %o",neto_final.toFixed(2));
        neto_input.val(neto_final.toFixed(2));
        neto_total = neto_final.toFixed(2);

        $("span.neto_total").html(" $ " + neto_total);
        return false;
    }



    $(".add_checks_in").click(function() {
        console.debug("add_checks_in clicked");
        var n_row = $(".section_cheques").find('.bancos_inst').length + 1;
        console.debug("====> n_row: %o", n_row);

        var _new_cheque_fields = '';

        _new_cheque_fields += '<div class="row " id="row_' + n_row + '">';
        _new_cheque_fields += '    <div class="col-lg-3">';
        _new_cheque_fields += '        <label class="">Nro : </label>';
        _new_cheque_fields += '        <input type="text" class="form-control" id="operationChequeNro" name="cheche_in[' + n_row + '][nro]" autocomplete="off"/>';
        _new_cheque_fields += '    </div>';
        _new_cheque_fields += '    <div class="col-lg-3">';
        _new_cheque_fields += '        <label class="">Banco: </label>';
        _new_cheque_fields += '        <input type="text" class="form-control bancos_inst typeahead " id="banco_ing_' + n_row + '"  data-id="' + n_row + '"  name="cheche_in[' + n_row + '][banco_nombre]" />';
        _new_cheque_fields += '        <input class="" type="hidden"  id="banco_ing_id_' + n_row + '" name="cheche_in[' + n_row + '][banco_id]" > ';
        _new_cheque_fields += '    </div> ';
        _new_cheque_fields += '    <div class="col-lg-3">';
        _new_cheque_fields += '        <label class="">Importe : </label>';
        _new_cheque_fields += '        <input type="numeric" class="form-control cheque_importe_in " id="operationImporte" name="cheche_in[' + n_row + '][importe]" style="text-align: right"/> ';
        _new_cheque_fields += '    </div> ';

        _new_cheque_fields += '    <div class="col-lg-1">';
        _new_cheque_fields += '        <label class=""></label>';
        _new_cheque_fields += '        <button class="btn btn-danger btn-link btn-xs btn-block delete_checks_in"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button> ';
        _new_cheque_fields += '    </div> ';
        _new_cheque_fields += '</div>';

        //console.log(_new_cheque_fields);
        $(".section_cheques").append(_new_cheque_fields);
        $('.section_cheques .cheque_importe_in').maskMoney({ allowNegative: false, thousands: '.', decimal: ',', allowZero: true, prefix: '$' }); //.trigger('mask.maskMoney');
        calcular_valores();
        console.debug("====> TOTAL CHE: %o", $(".section_cheques").find('.bancos_ins').length);
        return false;
    });

    $(document).on('click', '.delete_checks_in', function() {
        console.log("====> delete_checks_in was clicked");
        $(this).closest('.row').remove();
        calcular_valores();
        return false;

    });


    $(document).on('keyup', '.bancos_inst', function() {

        var id = $(this).data('id');
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
                            console.log(i);
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
            },
            updater: function(item) {
                var data = map[item];
                $("#banco_ing_id_" + id + "").val(data.id);
                return data.razon_social;
            }
        }).typeahead();
    });

    $(document).on('change', '.cheque_importe_in', function() {
        calcular_valores();
    });

    var validar_form_1 = function() {
        //console.debug("====> VALIDACION DE FORMULARIO 1:\n");            
        var _step1_inputs = $("#step1").find("input");
        //console.debug("===> INPUTS %o",_step1_inputs.length);
        var result = true;
        _step1_inputs.each(function(index, item) {
            // console.debug("====> input[%o]: %o",index,item);
            if ($(item).val().length < 1 || $('#chequeValido').val() == '0') {
                alert("Todos los campos deben ser completados, vuelva a intentarlo.");
                item.focus();
                result = false;
                return false;
            }
        });
        return result;
    };

    var validar_form_2 = function() {
        //console.debug("====> VALIDACION DE FORMULARIO 2:\n");     
        var radios = $("#step2").find("input[type=radio]");
        var texts = $("#step2").find("input[type=text]");
        var checked_radio = false;
        radios.each(function(index, item) {
            if ($(item).is(':checked')) {
                checked_radio = true;
            }
        });

        if (!checked_radio) {
            alert("Debe Seleccionar un Inversor.");
            return false;
        }
        var result = true;
        if (texts.length == 0) {
            alert("Debe cargar al menos un cheque de salida.");
            return false;
        } else {
            texts.each(function(index, item) {
                if ($(item).val().length < 1) {
                    alert("Debe completar todos los Datos de Cheques.");
                    $(item).focus();
                    result = false;
                    return false;
                }
            });
        }

        return result;
    }
    cheque_nro.on('change', function() {
        validarCheque($("#banco_id").val(), cheque_nro.val());
    });

    importe_input.on('change', function() {
        calcular_valores();
    });
    dias_input.on('change', function() {
        var today = new Date();
        if (dias_input.val() != "") {
            //today.setDate(today.getDate()+ parseInt(dias_input.val()) - 2);
            today.setDate(today.getDate() + parseInt(dias_input.val()));
            console.debug("===> DATE RESULTED FROM total NAme: %o", today);
            console.debug("===> DATE RESULTED FROM total NAme: %o", today.getDay());
            if (today.getDay() == 1) {
                today.setDate(today.getDate() - 4);
            } else if (today.getDay() == 2) {
                today.setDate(today.getDate() - 4);
            } else {
                today.setDate(today.getDate() - 2);
            }
            console.debug("===> DATE RESULTED FROM total NAme: %o", today);

        } else {

        }

        var mes = today.getMonth() + 1;
        fecha_vencimiento.val(today.getDate() + '-' + mes + '-' + today.getFullYear());
        calcular_valores();
    });
    comision_input.on('change', function() {
        //console.debug("\====> comision_input\n");
        calcular_valores();
    });
    tasa_mensual_input.on('change', function() {
        //console.debug("\n====> tasa_mensual_input\n");
        var tasa_mensual = parseFloat($(this).val().replace(',', '.'));
        var new_tasa_anual = (tasa_mensual * 12).toFixed(2);
        tasa_anual_input.val(new_tasa_anual);
        calcular_valores();
    });
    gasto_input.on('change', function() {
        //console.debug("\====> gasto_input\n");
        calcular_valores();
    });

    // CampoFecha de Veciento
    var d = new Date();
    var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
    fecha_vencimiento.datepicker({
        beforeShowDay: function(date) {
            var datestring = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [feriados.indexOf(datestring) == -1]
        },
        minDate: today,
        dateFormat: 'dd-mm-yy',
        setDate: today,
        onSelect: function(dateText, int) {

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

            dias_input.val(total_days);
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
            var data_ajax = {
                type: "POST",
                url: 'bank/buscadorDeBancos',
                data: { action: 'search', code: query, type: 'E' },
                success: function(data) {
                    //console.debug("===> BANCOS: %o", data);
                    if (data == false) {
                        return false;
                    }
                    objects = [];
                    map = {};
                    $.each(data, function(i, object) {
                        var key = object.razon_social + " - " + object.sucursal
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

            $("#banco_id").val(data.id);
            banco_1 = data;
            validarCheque($("#banco_id").val(), cheque_nro.val());
            return data.razon_social;
        }
    });

    //validador de cheques duplicados
    var validarCheque = function(banco, numero) {
        if (banco != "" && numero != "") {
            WaitingOpen('Validando Cheque...');
            $.ajax({
                type: 'POST',
                data: { id: banco, nro: numero },
                url: 'index.php/check/validate',
                success: function(result) {
                    if (result == 0) {
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
                error: function(result) {
                    WaitingClose();
                    alert("Error al validar el cheque ingresado. Intente nuevamente la operación.");
                    $('#chequeValido').val('0');
                },
                dataType: 'json'
            });
        } else {
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
            query = query.split("-").join("");
            query = query.split("_").join("");
            var data_ajax = {
                type: "POST",
                url: 'agent/buscadorDeAgentes',
                data: { action: 'search', code: query, type: 'E' },
                success: function(data) {
                    if (data == false) {
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
                    console.debug("ERROR: %o", error_msg);
                    alert("error_msg: " + error_msg);
                },
                dataType: 'json'
            };
            $.ajax(data_ajax);

        },
        updater: function(item) {
            var data = map[item];
            // console.debug("==> updater data.cuit: %o",data);
            $("#agente_emisor_id").val(0);
            if (emisor_cuit_input.val().length == data.cuit.length && emisor_cuit_input.val() != data.cuit) {
                $("#operationEmisorRazonSocial").val(null);
                $("#agente_emisor_id").val('0');
                emisor_data = {
                    id: -1,
                    cuit: '',
                    nombre: '',
                    apellido: '',
                    razon_social: '',
                    domicilio: ''
                };
                return emisor_cuit_input.val();
            } else {

                $("#agente_emisor_id").val(data.id);
                if (data.razon_social != '') {
                    $("#operationEmisorRazonSocial").val(data.razon_social);
                } else {
                    $("#operationEmisorRazonSocial").val(data.nombre + " " + data.apellido);
                }
                emisor_data = data;
                return data.cuit;
            }



        }
    });



    //$(document).on('change',"#operationEmisorApellido",function(){
    $(document).on('change', "#operationEmisorRazonSocial", function() {
        if ($("#agente_emisor_id").val() == 0) {
            emisor_data.id = 0;
            emisor_data.cuit = $('#operationEmisorCuit').val();
            emisor_data.nombre = $('#operationEmisorRazonSocial').val();
            emisor_data.apellido = "";
            emisor_data.razon_social = $(this).val();
            emisor_data.domicilio = "";
            console.debug("===> nuevo emisor");
        }

        return false;
    });

    $(document).on('change', "#operationTomadorApellido", function() {
        if ($("#agente_tomador_id").val() == 0) {

            //console.debug("===> operationTomadorApellido - tomador_data: %o",tomador_data);
            tomador_data.id = 0;
            tomador_data.cuit = $('#operationTomadorCuit').val();
            tomador_data.nombre = $('#operationTomadorNombre').val();
            tomador_data.apellido = $('#operationTomadorApellido').val();
            tomador_data.razon_social = $('#operationTomadorNombre').val() + " " + $('#operationTomadorApellido').val();
            tomador_data.domicilio = " fgfgfgg";
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
            var data_ajax = {
                type: "POST",
                url: 'agent/buscadorDeAgentes',
                data: { action: 'search', code: query, type: 'T' },
                success: function(data) {
                    if (data == false) {
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
                    //console.debug("ERROR Tenedor: %o",error_msg);
                    alert("error_msg: " + error_msg);
                },
                dataType: 'json'
            };
            $.ajax(data_ajax);

        },
        updater: function(item) {
            var data = map[item];
            /*
            console.debug("ERROR: %o",data);
            $("#operationTomadorNombre").val(data.nombre);
            $("#operationTomadorApellido").val(data.apellido);
            $("#agente_tomador_id").val(data.id);
            
            return data.cuit;*/
            // console.debug("==> updater emisor: %o",emisor_cuit_input.val());
            //console.debug("==> updater data.cuit: %o",data.cuit);
            if (tenedor_cuit_input.val().length == data.cuit.length && tenedor_cuit_input.val() != data.cuit) {
                $("#operationTomadorNombre").val(null);
                $("#operationTomadorApellido").val(null);
                $("#agente_tomador_id").val('0');
                tomador_data = {
                    id: -1,
                    cuit: '',
                    nombre: '',
                    apellido: '',
                    razon_social: '',
                    domicilio: ''
                };
                console.debug("===> operationEmisorApellido - emisor_data: %o", tomador_data);
                return tenedor_cuit_input.val();
            } else {
                $("#operationTomadorNombre").val(data.nombre);
                $("#operationTomadorApellido").val(data.apellido);
                $("#agente_tomador_id").val(data.id);
                tomador_data = data;
                console.debug("===> operationEmisorApellido - emisor_data: %o", tomador_data);
                return data.cuit;
            }
        }
    });

    back1_tb.on('click', function() {
        var step = $(this).data('step');
        //console.debug("===> BUTTON back1_tb clicked: %o",step);
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');

        var tab_index = $('.nav-tabs > li.active').index();
        //console.debug("===> BACK tab active: %o",tab_index);
        if (tab_index == 0) {
            $(this).addClass("hidden");
            step1_tb.removeClass("hidden");
        } else {
            $(this).removeClass("hidden");
        }
        step1_tb.removeClass("hidden");


    });

    step1_tb.on('click', function() {
        var step = $(this).data('step');
        //console.debug("===> BUTTON step1_bt clicked: %o",step);
        var tab_index = $('.nav-tabs > li.active').index();
        //console.debug("===> NEXT tab active: %o",tab_index);
        switch (tab_index) {
            case 0:
                {
                    if (validar_form_1()) {
                        $('.nav-tabs >   .active').next('li').find('a').trigger('click');
                        back1_tb.removeClass("hidden");
                    } else {
                        return false;
                    }
                    $(this).removeClass("hidden");
                    //return false;
                    break;
                }
            case 1:
                {
                    if (validar_form_2()) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        $(this).addClass("hidden");
                        back1_tb.removeClass("hidden");
                        save_tb.removeClass("hidden");
                    } else {
                        return false;
                    }
                    break;
                }
            case 2:
                {
                    //$(this).addClass("hidden");
                    print_liquidacion();
                    back1_tb.removeClass("hidden");
                }
            default:
                {
                    break;
                }
        }


    });





    add_cheque_salida_bt.on('click', function() {

        if ($("#salid_tb").is(":hidden"))
            console.debug("====> Agregar Nuevo Cheque"); {
            $("#salid_tb").removeClass("hidden");
        }

        total_rows = 0;
        if ($("#salid_tb").find("tbody tr:last").length > 0) {
            total_rows = $("#salid_tb").find("tbody tr").length;
            next_row = $("#salid_tb").find("tbody tr:last").data('next') + 1;
        } else {
            total_rows = 0;
            next_row = 1;
        }

        var total_rows = $("#salid_tb").find("tbody tr").length;
        var last = $("#salid_tb").find("tbody tr:last").data();
        var new_row = '<tr id="tr_' + (next_row - 1) + '" data-next="' + next_row + '" >';
        new_row += '<td><input type="text" class="form-control banco typeahead"  name="cheque_salida[' + next_row + '][banco_nombre]" id="operation_' + next_row + '_CheckOutBanco"  data-id="' + next_row + '" placeholder="Banco" autocomplete="off">';
        new_row += '<input type="hidden"   name="cheque_salida[' + next_row + '][banco_id]" id="banco_id_' + next_row + '" ></td>';
        new_row += '<td><input type="text" class="form-control nro" name="cheque_salida[' + next_row + '][nro]" id="operation_' + next_row + '_CheckOutNro"  placeholder="Nro Cheque" style="text-align: right"></td>';
        new_row += '<td><input type="text" class="form-control importe" name="cheque_salida[' + next_row + '][importe]" id="operation_' + next_row + '_CheckOutImporte"  placeholder="Importe" style="text-align: right"></td>';
        new_row += '<td><input type="text" class="form-control fecha datepicker" name="cheque_salida[' + next_row + '][fecha]" id="operation_' + next_row + '_CheckOutFecha"  placeholder="Fecha"></td>';
        new_row += '<td><button class="btn btn-danger btn-xs bt_check_delete" data-id="' + (next_row - 1) + '">Eliminar</button></td>'
        new_row += '</tr>';
        $("#salid_tb").find("tbody").append(new_row);
        $('input.form-control.importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' }); //.trigger('mask.maskMoney');
        $('input.form-control.fecha').datepicker({
            minDate: today,
            dateFormat: 'dd-mm-yy',
            setDate: today,
        });
        return false;
    });


    add_tranfer_salida_tb.on('click', function() {

        total_rows = 0;
        var table = $('#salid_tb_tranferencia');

        if (table.is(":hidden"))
            console.debug("====> Agregar Nuevo Cheque"); {
            table.removeClass("hidden");
        }

        if (table.find("tbody tr:last").length > 0) {
            total_rows = table.find("tbody tr").length;
            next_row = table.find("tbody tr:last").data('next') + 1;
        } else {
            total_rows = 0;
            next_row = 1;
        }

        var total_rows = $("#salid_tb_tranferencia").find("tbody tr").length;
        var last = table.find("tbody tr:last").data();
        var new_row = '<tr id="tr_' + (next_row - 1) + '" data-next="' + next_row + '" >';
        new_row += '<td><input type="text" class="form-control transfe_banco typeahead"  name="tranferencia_salida[' + next_row + '][banco_nombre]" id="operation_' + next_row + '_TransfeOutBanco"  data-id="' + next_row + '" placeholder="Banco">';
        new_row += '<input type="hidden"   name="tranferencia_salida[' + next_row + '][banco_id]" id="transfe_banco_id_' + next_row + '" ></td>';
        new_row += '<td><input type="text" class="form-control nro" name="tranferencia_salida[' + next_row + '][cbu]" id="operation_' + next_row + '_TransfeOutCbu"  placeholder="Nro / Alias CBU" maxlength="22" style="text-align: right"></td>';
        new_row += '<td><input type="text" class="form-control importe" name="tranferencia_salida[' + next_row + '][importe]" id="operation_' + next_row + '_TransfeOutImporte"  placeholder="Importe" value="0.00" style="text-align: right"></td>';
        new_row += '<td><input type="text" class="form-control fecha datepicker" name="tranferencia_salida[' + next_row + '][fecha]" id="operation_' + next_row + '_TransfeOutFecha"  placeholder="Fecha"></td>';
        new_row += '<td><button class="btn btn-danger btn-xs bt_transferencia_delete" data-id="' + (next_row - 1) + '">Eliminar</button></td>'
        new_row += '</tr>';
        $("#salid_tb_tranferencia").find("tbody").append(new_row);
        $('#salid_tb_tranferencia input.form-control.importe').maskMoney({ allowNegative: false, thousands: '', decimal: '.' }); //.trigger('mask.maskMoney');
        $('#salid_tb_tranferencia input.form-control.fecha').datepicker({
            minDate: today,
            dateFormat: 'dd-mm-yy',
            setDate: today,
        });
        return false;
    });



    $(document).on('keyup', '.importe', function() {
        var _neto_total = parseFloat(neto_total).toFixed(2);
        var input_importes = $("#salid_tb,#salid_tb_tranferencia").find("input.form-control.importe");

        console.debug("====> input_importes: %o", input_importes.length);
        console.debug("====> _neto_total: %o", _neto_total);

        var total = 0;
        input_importes.each(function(index, item) {
            console.debug("====> $(item).val(): %o", $(item).val());
            total += parseFloat($(item).val());
        });
        console.debug("====> TOtal: %o", total.toFixed(2));
        console.debug("====> neto_total: %o", parseFloat(neto_total).toFixed(2));
        console.log(neto_total);
        console.log(Number(neto_total));
        console.log((total.toFixed(2) >= Number(neto_total)));
        if (total.toFixed(2) > Number(neto_total)) {
            console.debug("====> _importe: %o", total);
            alert(" Los importes de los cheques Agregados no pueden superar al Neto a pagar: ");
            return false;
        }
        total_valores_pagar = total;
    });

    $(document).on('click', '.banco', function() {
        var id = $(this).data('id');
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
                            var key = object.razon_social + " - " + object.sucursal
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

                $("#banco_id_" + id + "").val(data.id);
                return data.razon_social;
            }
        }).typeahead();
    });


    $(document).on('click', '.transfe_banco', function() {
        var id = $(this).data('id');
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
            },
            updater: function(item) {
                var data = map[item];

                $("#transfe_banco_id_" + id + "").val(data.id);
                return data.razon_social;
            }
        }).typeahead();
    });

    $(document).on('click', '.bt_check_delete', function() {
        var id = $(this).data('id');
        if ($("#salid_tb").find("tbody tr#tr_" + id).length > 0) {
            $("#salid_tb").find("tbody tr#tr_" + id).remove();
        }
        return false;
    });

    $(document).on('click', '.bt_transferencia_delete', function() {
        var id = $(this).data('id');
        //console.debug("===> .bt_transferencia_delete: %o",id);
        if ($("#salid_tb_tranferencia").find("tbody tr#tr_" + id).length > 0) {
            console.debug("===> .bt_transferencia_delete: %o", id);
            $("#salid_tb_tranferencia").find("tbody tr#tr_" + id).remove();
        }
        return false;
    });

    var print_liquidacion = function() {
        var tr_cheques_salida = $("#step2").find('table#salid_tb tbody').find('tr'); //.find("input[type=text]");
        var liquidacion_final = [];

        tr_cheques_salida.each(function(idex, item) {
            var inputs = $(item).find("input[type=text]");
            var temp = [];
            inputs.each(function(sindex, sitem) {
                temp.push($(sitem).val());
            });
            temp.splice(2, 0, emisor_data.apellido + ", " + emisor_data.nombre);
            temp.splice(3, 0, operation.tasaM);
            temp.splice(4, 0, operation.cheque.dias);
            liquidacion_final.push(temp);
        });

        var tabla_cheque_salida = "";
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
        tabla_cheque_salida += "<tr>";
        tabla_cheque_salida += "<td>" + banco_1.razon_social + "</td>";
        tabla_cheque_salida += "<td>" + operation.cheque.nro + "</td>";
        tabla_cheque_salida += "<td>" + emisor_data.razon_social + "</td>";
        tabla_cheque_salida += "<td>" + operation.cheque.vencimiento + "</td>";

        tabla_cheque_salida += "<td>" + operation.tasaM + "</td>";
        tabla_cheque_salida += "<td>" + operation.cheque.dias + "</td>";
        tabla_cheque_salida += "<td class='text-rigth'>" + parseFloat(operation.cheque.importe).toFixed(2) + "</td>";
        tabla_cheque_salida += "</tr>";

        //console.debug("===> operation: %o",operation);
        console.debug("===> emisor_data: %o", emisor_data);
        console.debug("===> tomador_data: %o", tomador_data);

        $("#resumen_cheque").find("tbody").empty().append(tabla_cheque_salida);
        var inversor_data = $('input[name=inversor_id]:checked').data();
        $("#step3").find("h3").html(inversor_data.name);
        $("span.cliente_nombre").html((tomador_data.razon_social != '') ? tomador_data.razon_social : tomador_data.nombre + ' ' + tomador_data.apellido);
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

    save_tb.click(function() {
        var form_data = $("form").serialize();
        console.debug("===> Form data: %o", form_data);
        //return false;
        //WaitingOpen();
        $.ajax({
            type: 'POST',
            data: $("form").serialize(),
            url: 'index.php/operation/addOperation',
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

});