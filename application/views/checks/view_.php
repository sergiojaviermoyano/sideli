<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          Revise que todos los campos esten completos
      </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Banco <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="hidden" id="bancoId">
      <input type="text" class="form-control" placeholder="" id="razon_social" value="" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
  <div class="col-xs-1">
      <button type="button" class="btn btn-info" id="btnBuscar"><i class="fa fa-search"></i></button>
  </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Fecha <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="text" class="form-control" placeholder="" id="fecha" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Número <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="text" class="form-control" placeholder="" id="sucursal" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Vencimiento <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="text" class="form-control" placeholder="" id="sucursal" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Importe <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="text" class="form-control" placeholder="" id="sucursal" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Emisor <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="sucursal" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
  <div class="col-xs-1">
      <button type="button" class="btn btn-info" id="btnSave"><i class="fa fa-search"></i></button>
  </div>
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Es Propio <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-1">
      <input type="checkbox" style="margin-top: 10px;">
    </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Observación <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-10">
      <input type="text" class="form-control" placeholder="" id="sucursal" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>


</div>

<script>
$('#btnBuscar').click(function(){
  buscadorDeBancos($('#razon_social').val(), $('#bancoId'), $('#razon_social'), $('#fecha'));
});

$('#razon_social').keyup(function(e){
    var code = e.which;
    if(code==13){
      e.preventDefault();
      buscadorDeBancos($('#razon_social').val(), $('#bancoId'), $('#razon_social'), $('#fecha'));
    }
  });
</script>