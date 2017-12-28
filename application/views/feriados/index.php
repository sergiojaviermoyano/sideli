<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Feridos</h3>
                </div>
                <div class="box-body">
                    <form class="form-inline" >
                        <input type="hidden" id="feriadoId" name="id" >
                        <div class="form-group">
                            <label for="inputDescription">Descripción</label>
                            <input type="text"  name="descripcion" class="form-control" id="inputDescription" placeholder="Nombre o Descripción de Feriado">
                        </div>
                        <div class="form-group">
                            <label for="inputFecha">Fecha</label>
                            <input type="text" name="fecha" class="form-control datepicker" id="inputFecha" placeholder="dd-mm-aaa">
                        </div>
                        <button type="submit" class="btn btn-info btn-sm">Guardar</button>
                        <button type="reset" class="btn btn-success btn-sm">Limpiar</button>
                    </form>
                    <table id="users" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <!-- <th>Nro</th>-->
                            <th>Feriado</th>
                            <th>Fecha</th>
                            <th width="20%">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($list)):?>
                                <?php foreach($list as $item):?>
                                    <tr>
                                        <!-- <td><?php echo $item['id']?></td> -->
                                        <td><?php echo $item['descripcion']?></td>
                                        <td><?php echo date('d-m-Y',strtotime($item['fecha']))?></td>
                                        <td>
                                            <?php  if (strpos($permission,'Edit') !== false) {
                                                echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" data-obj="'.htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8').'"  ></i>';
                                            }
                                            if (strpos($permission,'Del') !== false) {
                                                echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" data-id="'.$item['id'].'" ></i>';
                                            }
                                            
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function editDate(data,permission){
    console.log(data);
    console.log(permission);
    return false;
}
function deleteDate(id,permission){
    console.log(id);
    console.log(permission);
    return false;
}
$(function(){

    function refresh_view(){
        WaitingOpen();
        $('#content').empty();
        var controller=$(this).data('controller');
        var method=$(this).data('method');
        var actions=$(this).data('actions');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/feriado/index/'+$("#permission").val(),
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
    
    $("#inputFecha").datepicker({dateFormat: 'dd-mm-yy',});


    $(".fa-pencil").on('click',function(){
        var data=$(this).data('obj');
        var from = data.fecha.split("-");
        var f = new Date(from[2], from[1], from[0]);
        $("#feriadoId").val(data.id);
        $("#inputDescription").val(data.descripcion);
        $("#inputFecha").val( from[2]+'-'+from[1]+'-'+from[0]);
        return false;
    });

    $(".fa-times-circle").on('click',function(){
        var id=$(this).data('id');
        console.log(id);
       

        var data_ajax={
            type: "POST",
            url: 'feriado/deleteDay',                     
            data: {id:id},
            success: function(data) {
               
                refresh_view();
                return false;
            },
            error: function(error_msg) {
                alert("error_msg: " + error_msg);
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
        return true;
    });


    $("form").submit(function(){

        if($("#inputDescription").val().length==0){
            alert("Debe completar el campo Descripción");
            $("#inputDescription").focus();
            return false;
        }
        if($("#inputFecha").val().length==0){
            alert("Debe completar el campo Fecha");
            $("#inputFecha").focus();
            return false;
        }

        var form_data=$("form").serialize();
        var data_ajax={
            type: "POST",
            url: 'feriado/addDay',                     
            data: $("form").serialize(),
            success: function(data) {
                refresh_view();
                return false;
            },
            error: function(error_msg) {
                alert("error_msg: " + error_msg);
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
        return false;
    });
});
</script>