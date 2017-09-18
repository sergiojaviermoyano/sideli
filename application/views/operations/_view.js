$(function() {

    var emisor_cuit_input = $(this).find("input#operationEmisorCuit");
    var tenedor_cuit_input = $(this).find("input#operationTomadorCuit");
    var banco_input = $(this).find("input#operationBanco");
    var importe_input = $(this).find("input#operationImporte");
    var fecha_vencimiento = $(this).find("input#operationFechaVen");
    var dias_input = $(this).find("input#operationDias");
    var tasa_mensual_input = $(this).find("input#opterationTasaMensual");
    var tasa_anual_input = $(this).find("input#opterationTasaAnual");
    var interes_input = $(this).find("input#opterationInteres");
    var comision_input = $(this).find("input#opterationComision");
    var comision_total_input = $(this).find("input#opterationComisionTotal");
    var impuesto_cheque_input = $(this).find("input#operationImpuestoCheque");
    var gasto_input = $(this).find("input#operationGasto");
    var iva_input = $(this).find("input#operationIva");
    var sellado_input = $(this).find("input#operationSellado");
    var neto_input = $(this).find("input#operationNeto");
    var step1_tb = $(this).find("button#btnNext1");
    var back1_tb = $(this).find("button#btnBack1");
    var save_tb = $(this).find("button#btnSave");
    var cheque_salida_nro = $(this).find("button#operationCheckOutNro");
    var cheque_salida_importe = $(this).find("button#operationCheckOutImporte");
    var cheque_salida_fecha = $(this).find("button#operationCheckOutFecha");
    var add_cheque_salida_bt = $(this).find("button.add_check_out");




    importe_input.on('change', function() {
        dias_input.trigger('change');
    });
    dias_input.on('change', function() {
        console.debug("\n==> Importe: %o", importe_input.val());
        var importe = parseFloat(importe_input.val());
        var tAnual = parseFloat(tasa_anual_input.val());
        var cantDias = $(this).val();
        var comision = parseFloat(comision_input.val().replace(',', '.'));
        var impuesto = parseFloat(impuesto_cheque_input.data('valor').replace(',', '.'));
        var gastos = parseFloat(gasto_input.val().replace(',', '.'));
        var iva = parseFloat(iva_input.val().replace(',', '.'));
        var sellado = parseFloat(sellado_input.val().replace(',', '.'));


        console.debug("\n==> Importe: %o", importe);
        console.debug("\n==> TasaAnual: %o", tAnual);
        console.debug("\n==> cantDias: %o", cantDias);
        console.debug("\n==> comision: %o", comision);
        console.debug("\n==> impuesto: %o", impuesto);
        console.debug("\n==> iva: %o", iva);
        console.debug("\n==> sellado: %o", sellado);

        var interes = importe * (tAnual / 365) * (cantDias / 100);
        console.debug("\n==> Interes: %o", interes);
        interes_input.val(interes.toFixed(2));
        var comision_total = importe.toFixed(2) * comision / 100;
        console.debug("\n==> comision_total: %o", comision_total);
        comision_total_input.val(comision_total.toFixed(2));
        impuesto_cheque = (importe * impuesto) / 100;
        console.debug("\n==> impuesto_cheque: %o", impuesto_cheque);
        impuesto_cheque_input.val(impuesto_cheque.toFixed(2));
        var compra = importe - interes - impuesto_cheque - gastos;
        console.debug("\n==> compra: %o", compra);
        var neto1 = compra - comision_total;
        console.debug("\n==> neto1: %o", neto1);
        var iva_total = (interes + comision_total) * (iva / 100);
        console.debug("\n==> iva_total: %o", iva_total);
        var sellado_total = (importe * (0.5 / 100)) + (importe * (0.5 / 100) * (20 / 100)) + (importe * (0.5 / 100) * (20 / 100));
        console.debug("\n==> sellado: %o", sellado);
        sellado_input.val(sellado_total.toFixed(2));
        var neto_final = neto1 - iva_total - sellado_total;
        console.debug("\n==> neto_final: %o", neto_final.toFixed(2));
        neto_input.val(neto_final.toFixed(2));



    });

    // CampoFecha de Veciento
    var d = new Date();
    var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
    fecha_vencimiento.datepicker({
        minDate: today,
        dateFormat: 'dd-mm-yy',
        setDate: today,
        onSelect: function(dateText, int) {
            var from_date = today;
            var days_to = new Date(int.currentYear, int.currentMonth, int.currentDay);
            var total_days = (days_to - from_date) / (1000 * 60 * 60 * 24);
            dias_input.val(Math.round(total_days) + 2);
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
        }
    });


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
                        var key = object.cuit + " - " + object.razon_social
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
                        var key = object.cuit + " - " + object.razon_social
                        map[key] = object;
                        objects.push(key);
                    });
                    return process(objects);
                },
                error: function(error_msg) {
                    console.debug("ERROR Tenedor: %o", error_msg);
                    alert("error_msg: " + error_msg);
                },
                dataType: 'json'
            };
            $.ajax(data_ajax);

        },
        updater: function(item) {
            var data = map[item];
            console.debug("ERROR: %o", data);
            $("#operationTomadorNombre").val(data.nombre);
            $("#operationTomadorApellido").val(data.apellido);
            return data.cuit;
        }
    });

    back1_tb.on('click', function() {
        var step = $(this).data('step');
        console.debug("===> BUTTON back1_tb clicked: %o", step);
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');

        var tab_index = $('.nav-tabs > li.active').index();
        console.debug("===> BACK tab active: %o", tab_index);
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
        console.debug("===> BUTTON step1_bt clicked: %o", step);
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
        var tab_index = $('.nav-tabs > li.active').index();
        console.debug("===> NEXT tab active: %o", tab_index);
        if (tab_index == 2) {
            $(this).addClass("hidden");
        } else {
            $(this).removeClass("hidden");
        }
        back1_tb.removeClass("hidden");

    });

    /*save_tb.on('click',funtion(){

    });*/

    cheque_salida_fecha.datepicker({
        minDate: today,
        dateFormat: 'dd-mm-yy',
        setDate: today,
    });

    add_cheque_salida_bt.on('click', function() {
        console.debug("====> Agregar Nuevo Cheque");
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
        new_row += '<td><input type="text" class="form-control nro" name="cheque_salida[\'' + next_row + '\'][\'nro\']" id="operation_' + next_row + '_CheckOutNro"  placeholder="Nro Cheque"></td>';
        new_row += '<td><input type="text" class="form-control importe" name="cheque_salida[\'' + next_row + '\'][\'importe\']" id="operation_' + next_row + '_CheckOutImporte"  placeholder="Importe"></td>';
        new_row += '<td><input type="text" class="form-control datepicker" name="cheque_salida[\'' + next_row + '\'][\'fecha\']" id="operation_' + next_row + '_CheckOutFecha"  placeholder="Fecha"></td>';
        new_row += '<td><button class="btn btn-danger btn-xs bt_check_delete" data-id="' + (next_row - 1) + '">Eliminar</button></td>'
        new_row += '</tr>';
        $("#salid_tb").find("tbody").append(new_row);
        return false;
    });

    $(document).on('click', '.bt_check_delete', function() {
        var id = $(this).data('id');
        console.debug("===> DELETE CHEQUE: %o", id);

        if ($("#salid_tb").find("tbody tr#tr_" + id).length > 0) {
            $("#salid_tb").find("tbody tr#tr_" + id).remove();
        }
        return false;
    });




});