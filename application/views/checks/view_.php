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
      <input type="hidden" id="bancoId" value="<?php echo $data['check']['bancoId'];?>">
      <input type="text" class="form-control" placeholder="" id="razon_social"  value="<?php echo $data['check']['banco'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
  <div class="col-xs-1">
      <button type="button" class="btn btn-info" id="btnBuscarBanco"><i class="fa fa-search"></i></button>
  </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Fecha <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input class="form-control" type="text" id="fecha"  value="<?php echo $data['check']['fecha'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
    </div>
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Número <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="text" class="form-control" placeholder="" id="numero"  value="<?php echo $data['check']['numero'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Vencimiento <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input class="form-control" type="text" id="vencimiento"  value="<?php echo $data['check']['vencimiento'];?>"vencimiento <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>>
    </div>
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Importe <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-4">
      <input type="text" class="form-control" placeholder="" id="importe" value="<?php echo $data['check']['importe'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Emisor <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-9">
      <input type="hidden" id="agenteId" value="<?php echo $data['check']['agenteId'];?>">
      <input type="text" class="form-control" placeholder="" id="agente" value="<?php echo $data['check']['emisor'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
  <div class="col-xs-1">
      <button type="button" class="btn btn-info" id="btnBuscarAgente"><i class="fa fa-search"></i></button>
  </div>
</div><br>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Observación <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-10">
      <input type="text" class="form-control" placeholder="" id="observacion" value="<?php echo $data['check']['observacion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>


</div>

<script>
$('#btnBuscarBanco').click(function(){
  buscadorDeBancos($('#razon_social').val(), $('#bancoId'), $('#razon_social'), $('#fecha'));
});

$('#razon_social').keyup(function(e){
    var code = e.which;
    if(code==13){
      e.preventDefault();
      buscadorDeBancos($('#razon_social').val(), $('#bancoId'), $('#razon_social'), $('#fecha'));
    }
  });

$('#btnBuscarAgente').click(function(){
  buscadorDeAgentes($('#agente').val(), $('#agenteId'), $('#agente'), $('#observacion'), 'E');
});

$('#agente').keyup(function(e){
    var code = e.which;
    if(code==13){
      e.preventDefault();
      buscadorDeAgentes($('#agente').val(), $('#agenteId'), $('#agente'), $('#observacion'), 'E');
    }
  });

</script>