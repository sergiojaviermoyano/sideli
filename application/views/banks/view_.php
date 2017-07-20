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
      <label style="margin-top: 7px;">Nombre <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="razon_social" value="<?php echo $data['bank']['razon_social'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Sucursal <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="sucursal" value="<?php echo $data['bank']['sucursal'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Estado<strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <select class="form-control" id="estado"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
        <?php 
            echo '<option value="ac" '.($data['bank']['estado'] == 'ac' ? 'selected' : '').'>Activo</option>';
            echo '<option value="in" '.($data['bank']['estado'] == 'in' ? 'selected' : '').'>Inactivo</option>';
        ?>
      </select>
    </div>
</div><br>
</div>