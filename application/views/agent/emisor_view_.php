
<div class="form-group">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
          <p>Revise que todos los campos esten completos<br></p>

      </div>
	</div>
</div>

<div class="form-group">
  <label class="col-sm-3">Nombre <strong style="color: #dd4b39">*</strong>: </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorNombre" name="EmisorNombre" value="<?php echo $data['emisor']['nombre'] ?>"/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Apellido <strong style="color: #dd4b39">*</strong>: </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorApellido" name="EmisorApellido" value="<?php echo $data['emisor']['apellido'] ?>"/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Cuit <strong style="color: #dd4b39">*</strong>: </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorCuit" name="EmisorCuit" value="<?php echo $data['emisor']['cuit'] ?>"/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Razon Social : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorRazonSocial" name="EmisorRazonSocial" value="<?php echo $data['emisor']['razon_social'] ?>"/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Domicilio : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorDomicilio" name="EmisorDomicilio"  value="<?php echo $data['emisor']['domicilio'] ?>"/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Teléfono : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorTelefono"  name="EmisorTelefono" name="EmisorTelefono" value="<?php echo $data['emisor']['telefono'] ?>"/>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3">Celular : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="EmisorCelular" name="EmisorCelular" value="<?php echo $data['emisor']['celular'] ?>"/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Email : </label>
  <div class="col-sm-9">
    <input type="email" class="form-control" id="EmisorEmail" name="EmisorEmail" value="<?php echo $data['emisor']['email'] ?>"/>
  </div>
</div>

<input type="hidden"  id="EmisorId" name="EmisorId" value="<?php echo $data['emisor']['id']?>" >
<input type="hidden"  id="EmisorTipo" name="EmisorTipo" value="<?php echo $data['emisor']['tipo']?>" >
