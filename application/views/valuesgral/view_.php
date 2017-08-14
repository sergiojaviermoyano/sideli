<div class="row">
  <div class="col-xs-12">
    <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
          <h4><i class="icon fa fa-ban"></i> Error!</h4>
          Revise que todos los campos esten completos
      </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Tasa <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="tasa" value="<?php echo $data['values']['tasa'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Impuestos <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="impuestos" value="<?php echo $data['values']['impuestos'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Gastos <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="gastos" value="<?php echo $data['values']['gastos'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Comisión <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="comision" value="<?php echo $data['values']['comision'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

</div>