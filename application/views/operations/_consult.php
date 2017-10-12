<div class="row">
  <div class="col-xs-8">
      <label> Número de Operación: <strong style="color: #dd4b39"> <?php echo str_pad($data['operation']['id'], 10, "0", STR_PAD_LEFT);?></strong> </label>
    </div>
  <div class="col-xs-4" style="text-align: right">
      <label> Fecha: <strong style="color: #dd4b39"> <?php echo date("d-m-Y h:i", strtotime($data['operation']['created'])); ?></strong> </label>
    </div>
</div><br>

<div class="row">
  <div class="col-xs-6">
      <label style="text-decoration: underline"> Datos Tenedor </s></label><br>
      <label> Nombre y Apellido: <strong style="color: #dd4b39"> <?php echo $data['tenedor']['apellido'].', '.$data['tenedor']['nombre'];?></strong> </label><br>
      <label> CUIT: <strong style="color: #dd4b39"> <?php echo $data['tenedor']['cuit'];?></strong> </label><br>
      <label> Dirección: <strong style="color: #dd4b39"> <?php echo $data['tenedor']['domicilio'];?></strong> </label>
    </div>
  <div class="col-xs-6">
      <label style="text-decoration: underline"> Datos Inversor </label><br>
      <label> Nombre y Apellido: <strong style="color: #dd4b39"> <?php echo $data['inversor']['razon_social'];?></strong> </label><br>
      <label> CUIT: <strong style="color: #dd4b39"> <?php echo $data['inversor']['cuit'];?></strong> </label><br>
      <label> Dirección: <strong style="color: #dd4b39"> <?php echo $data['inversor']['domicilio'];?></strong> </label>
    </div>
</div><br><br>

<div class="row">
	<div class="col-xs-12">
  		<label style="text-decoration: underline"> Valores Tomados </label><br>
  		<table width="100%" class="table table-bordered table-hover datatable">
			<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Librador</th><th>Fecha Pago</th><th>Tasa</th><th>Días</th><th>Importe</th></tr>
			<tr>
			<td><?php echo $data['banco']['razon_social'];?></td>
			<td style="text-align: center"><?php echo $data['operation']['nro_cheque'];?></td>
			<td><?php echo $data['emisor']['apellido'] . ' ' . $data['emisor']['nombre'];?></td>
			<td style="text-align: center"><?php echo date("d-m-Y", strtotime($data['operation']['fecha_venc']));?></td>
			<td style="text-align: right"><?php echo number_format($data['operation']['tasa_mensual'], 2, ',', '.');?></td>
			<td style="text-align: right"><?php echo number_format($data['operation']['nro_dias'], 0, ',', '.');?></td>
			<td style="text-align: right"><?php echo number_format($data['operation']['importe'], 2, ',', '.');?></td>
			</td></tr>
		</table><br>

		<table width="100%">
			<tr><td style="width:25%"></td><td style="text-align:left">TOTAL DE VALORES $</td><td style="text-align:right"><?php echo number_format($data['operation']['importe'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">INTERESES $</td><td style="text-align:right"><?php echo number_format($data['operation']['interes'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">IMP DEB Y CRED BANCARIOS $</td><td style="text-align:right"><?php echo number_format($data['operation']['impuesto_cheque'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">VALORES OTRA PLAZA $</td><td style="text-align:right"><?php echo number_format($data['operation']['gastos'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">COMISIONES $</td><td style="text-align:right"><?php echo number_format($data['operation']['comision_total'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">IVA $</td><td style="text-align:right"><?php echo number_format($data['operation']['iva'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">SELLADO $</td><td style="text-align:right"><?php echo number_format($data['operation']['sellado'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">NETO A LIQUIDAR $</td><td style="text-align:right"><?php echo number_format($data['operation']['neto'], 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td colspan="2"><hr></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">T</td><td style="text-align:right; cursor:pointer;" title="<?php echo 'Tasa Mensual ('.number_format($data['operation']['tasa_mensual'], 2, ',', '.').') x 12'; ?>"><?php echo number_format(($data['operation']['tasa_mensual'] * 12), 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">Compra</td><td style="text-align:right; cursor:pointer;" title="Total de Valores - Intereses - Imp Deb y Cred Bancarios - Valores Otra Plaza" ><?php echo number_format(($data['operation']['importe'] - $data['operation']['interes'] - $data['operation']['impuesto_cheque'] - $data['operation']['gastos']), 2, ',', '.');?></td></tr>
			<tr><td style="width:25%"></td><td style="text-align:left">Neto</td><td style="text-align:right; cursor:pointer;" title="Compra - Comisiones"><?php echo number_format(($data['operation']['importe'] - $data['operation']['interes'] - $data['operation']['impuesto_cheque'] - $data['operation']['gastos'] - $data['operation']['comision_total']), 2, ',', '.');?></td></tr>
		</table>
  	</div>
</div><br>

<div class="row">
	<div class="col-xs-12">
  		<label style="text-decoration: underline"> Valores Entregados </label><br>
  		<?php 
  			if(count($data['cheques']) > 0) 
  			{
  		?>
  				<label style="text-decoration: underline"> Cheques </label><br>
  				<table width="100%" class="table table-bordered table-hover datatable">
  					<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Importe</th><th>Fecha</th></tr>
  				<?php
  				foreach ($data['cheques'] as $che) {
  					echo '<tr>';
					echo  	'<td>'.$che[0].'</td>';
					echo  	'<td style="text-align: right">'.$che[1].'</td>';
					echo  	'<td style="text-align: right">'.$che[2].'</td>';
					echo  	'<td style="text-align: center">'.date("d-m-Y", strtotime($che[3])).'</td>';
					echo '</tr>';
  				}
  				?>
  				</table>

  		<?php 
  			} 
  			if(count($data['transferencias']) > 0)
  			{
  		?>
  				<label style="text-decoration: underline"> Transferencias </label><br>
  				<table width="100%" class="table table-bordered table-hover datatable">
  				<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Importe</th><th>Fecha</th></tr>
  				<?php
  				foreach ($data['transferencias'] as $che) {
  					echo '<tr>';
					echo  	'<td>'.$che[0].'</td>';
					echo  	'<td style="text-align: right">'.$che[1].'</td>';
					echo  	'<td style="text-align: right">'.$che[2].'</td>';
					echo  	'<td style="text-align: center">'.date("d-m-Y", strtotime($che[3])).'</td>';
					echo '</tr>';
  				}
  				?>
  				</table>
  		<?php 
  			}
  		?>