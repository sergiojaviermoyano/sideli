
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
    <input type="text" class="form-control" id="AgenteNombre" name="AgenteNombre" value="<?php echo $data['agente']['nombre'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Apellido <strong style="color: #dd4b39">*</strong>: </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="AgenteApellido" name="AgenteApellido" value="<?php echo $data['agente']['apellido'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Cuit <strong style="color: #dd4b39">*</strong>: </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="AgenteCuit" name="AgenteCuit" value="<?php echo $data['agente']['cuit'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Razon Social : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="AgenteRazonSocial" name="AgenteRazonSocial" value="<?php echo $data['agente']['razon_social'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Domicilio : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="AgenteDomicilio" name="AgenteDomicilio"  value="<?php echo $data['agente']['domicilio'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Teléfono : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="AgenteTelefono"  name="AgenteTelefono" name="AgenteTelefono" value="<?php echo $data['agente']['telefono'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3">Celular : </label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="AgenteCelular" name="AgenteCelular" value="<?php echo $data['agente']['celular'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3">Email : </label>
  <div class="col-sm-9">
    <input type="email" class="form-control" id="AgenteEmail" name="AgenteEmail" value="<?php echo $data['agente']['email'] ?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>/>
  </div>
</div>

<input type="hidden"  id="AgenteId" name="AgenteId" value="<?php echo $data['agente']['id']?>" >
<input type="hidden"  id="AgenteTipo" name="AgenteTipo" value="<?php echo $data['agente']['tipo']?>" >
