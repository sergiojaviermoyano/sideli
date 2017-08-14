
<div class="form-horizontal">




<div class="form-group">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
          <p>Revise que todos los campos esten completos<br></p>

      </div>
	</div>
</div>

<div class="form-group">
  <label class="col-sm-3">Razon Social : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="InversorRazonSocial" name="InversorRazonSocial" value="<?php echo $data['inversor']['razon_social'] ?>"/>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3">Cuit <strong style="color: #dd4b39">*</strong>: </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="InversorCuit" name="InversorCuit" value="<?php echo $data['inversor']['cuit'] ?>"/>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3">Domicilio : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="InversorDomicilio" name="InversorDomicilio"  value="<?php echo $data['inversor']['domicilio'] ?>"/>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3">Habilitado : </label>
  <div class="col-sm-9">
    <input type="checkbox" class="" id="InversorEstado" name="InversorEstado"  value="1" <?php echo ((int)$data['inversor']['estado']==1)?'checked':''; ?> />
  </div>
</div>

<input type="hidden"  id="InversorId" name="InversorId" value="<?php echo $data['inversor']['id']?>" >
</div>