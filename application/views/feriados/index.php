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
                        <div class="form-group">
                            <label for="inputDescription">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" id="inputDescription" placeholder="Nombre o Descripción de Feriado">
                        </div>
                        <div class="form-group">
                            <label for="inputFecha">Fecha</label>
                            <input type="text" name="fecha" class="form-control datepicker" id="inputFecha" placeholder="dd-mm-aaa">
                        </div>
                        <button type="submit" class="btn btn-info">Agregar</button>
                    </form>
                    <table id="users" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Feriado</th>
                            <th>Fecha</th>
                            <th width="20%">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($list)):?>
                                <?php foreach($list as $item):?>
                                    <tr>
                                        <td><?php echo $item['id']?></td>
                                        <td><?php echo $item['descripcion']?></td>
                                        <td><?php echo date('d-m-Y',strtotime($item['fecha']))?></td>
                                        <td>
                                            <?php  if (strpos($permission,'Edit') !== false) {
                                                echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="editDate('.$item['id'].',\'Edit\')"></i>';
                                            }
                                            if (strpos($permission,'Del') !== false) {
                                                echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="deleteDate('.$item['id'].',\'Del\')"></i>';
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
function editDate(id,permission){
    console.log(id);
    console.log(permission);
    return false;
}
function deleteDate(id,permission){
    console.log(id);
    console.log(permission);
    return false;
}
$(function(){
    
    $("#inputFecha").datepicker({dateFormat: 'dd-mm-yy',});


    /*$("span.fa.fa-fw.fa-pencil").click(function(){
        alert("ok");
        return false;
    });*/


    $("form").submit(function(){
        console.debug("====> AGREGAR FECHA SUBMIT");
        
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
                console.log("OK");
                console.log(data);

                return false;
            },
            error: function(error_msg) {
                //console.debug("ERROR Tenedor: %o",error_msg);
                alert("error_msg: " + error_msg);
            },
            dataType: 'json'
        };
        $.ajax(data_ajax);
        console.log(form_data);
        return false;
    });
});
</script>