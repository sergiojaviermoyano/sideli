<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Operations extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function List_all($estado=false){
		if($estado){
			$this->db->where("estado",$estado);
		}
		
		$this->db->order_by('created', 'DESC');
		$query= $this->db->get('operacion');
		//echo $this->db->last_query();
				//die("fin");
		
		if ($query->num_rows()!=0)
		{
			$result=$query->result_array();

			foreach($result as $key=>$item){
				$banco=$this->db->get_where('banco',array('id'=>$item['banco_id']));				
				$result[$key]['banco']=$banco->row()->razon_social;

				$tomador=$this->db->get_where('agente',array('id'=>$item['agente_tenedor_id']));				
				$result[$key]['tomador']=$tomador->row()->nombre." ".$tomador->row()->apellido;
				
				$tomador=$this->db->get_where('agente',array('id'=>$item['agente_tenedor_id']));				
				$result[$key]['tomador']=$tomador->row()->nombre." ".$tomador->row()->apellido;
			}
			
			return $result;	
		}
		else
		{
			return array();
		}
	}

	function getOperation($data){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('operacion',array('id'=>$id));
			if ($query->num_rows() != 0)
			{	
				$temp=$query->result_array();				
				$data['operation'] = $temp[0];
			} else {
				$temp = array();
				$data['operation'] = $temp;
				$query_val= $this->db->get('valores');

				if($query_val->num_rows()>0){
					$data['valores']=$query_val->row_array();
				}else{
					$data['valores']=array(
						'id' =>'',
						'tasa' =>0,      
						'impuestos' =>0,
						'gastos' =>0,
						'comision' => 0
					);
				}

				$query_investor=$this->db->get_where('inversor','estado=1');
				if($query_investor->num_rows()>0){
					$data['inversores']=$query_investor->result_array();
				}else{
					$data['inversores']=null;
				}
				
			}


			
			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;
           
			return $data;
		}

	}


	public function add($data=false){
		
		// Consulta si existe Agente Emisor por nro cuit, si no existe lo agrega
		$get_agente=$this->db->get_where('agente',array('cuit'=>$data['emisor_cuit']));
		if($get_agente->num_rows()==0){		
		
			$agente_emisor= array(
				'nombre'=>$data['emisor_nombre'],
				'apellido'=>$data['emisor_apellido'],
				'cuit'=>$data['emisor_cuit'],
				'razon_social'=>$data['emisor_nombre']." ".$data['emisor_apellido'],
				'domicilio'=>'',
				'tipo'=>1,
				'estado'=>'ac',
			);					
			$this->db->trans_start();
			$this->db->set('created', 'NOW()', FALSE);
			$this->db->set('updated', 'NOW()', FALSE);
			$result= $this->db->insert('agente', $agente_emisor);
			$data['agente_emisor_id'] = $this->db->insert_id();
			$this->db->trans_complete();
		}
		
		$get_agente=$this->db->get_where('agente',array('cuit'=>$data['tomador_cuit']));
		if($get_agente->num_rows()==0){		
			$agente_tomador= array(
				'nombre'=>$data['tomador_nombre'],
				'apellido'=>$data['tomador_apellido'],
				'cuit'=>$data['tomador_cuit'],
				'razon_social'=>$data['tomador_nombre']." ".$data['tomador_apellido'],
				'domicilio'=>'',
				'tipo'=>2,
				'estado'=>'ac',
			);

			$this->db->trans_start();
			$this->db->set('created', 'NOW()', FALSE);
			$this->db->set('updated', 'NOW()', FALSE);
			$result= $this->db->insert('agente', $agente_tomador);
			$data['agente_tomador_id'] = $this->db->insert_id();
			$this->db->trans_complete();
		}

		
		// Inserta Operacion en Operacion
		$params=array(
			'agente_emisor_id'=>$data['agente_emisor_id'],
			'agente_tenedor_id'=>$data['agente_tomador_id'],
			'banco_id'=>$data['banco_id'],
			'nro_cheque'=>$data['nro_cheque'],
			'importe'=>floatval($data['importe']),
			'fecha_venc'=>date('Y-m-d',strtotime($data['fecha_ven'])),
			'nro_dias'=>$data['nro_dias'],
			'tasa_mensual'=>floatval($data['tasa_mensual']),
			'interes'=>floatval($data['interes']),
			'impuesto_cheque'=>($data['impuesto_cheque']),
			'gastos'=>floatval($data['gastos']),
			'compra'=>floatval($data['compra']),
			'comision_valor'=>floatval($data['comision_valor']),
			'comision_total'=>floatval($data['comision_total']),
			'subtotal'=>floatval($data['subtotal']),
			'iva'=>floatval($data['iva']),
			'sellado'=>floatval($data['sellado']),
			'neto'=>floatval($data['neto']),
			'inversor_id'=>$data['inversor_id'],
			'observacion'=>$data['observacion'],	
			'estado'=>0,
			'created'=>date('Y-m-d h:m:i'),			
		);
		
		$this->db->trans_start();
		$result= $this->db->insert('operacion', $params);
		$operacion_id = $this->db->insert_id();
		
		// Inserta Cheque Recibido en CHeque
		$cheque_in=array(
			'fecha'=>date('Y-m-d',strtotime($data['fecha_ven'])),
			'bancoId'=>$data['banco_id'],
			'numero'=>$data['nro_cheque'],
			'importe'=>floatval($data['importe']),
			'estado'=>'AC',
			'observacion'=>null,
			'espropio'=>1,
			'tipo'=>1,
			'vencimiento'=>null,
			'agenteId'=>$data['agente_tomador_id']
		);
		$this->db->insert('cheques',$cheque_in);
		$cheque_id=$this->db->insert_id();
		$operacion_detalle=array(
			'operacion_id'=>$operacion_id,
			'cheque_id'=>$cheque_id,
		);
		$this->db->insert('operacion_detalle',$operacion_detalle);
		$operacion_detalle_id=$this->db->insert_id();

		// Inserta Cheques de Entregados en Cheques

		if(isset($data['cheque_salida'])){	
			foreach($data['cheque_salida'] as $key=>$item){
				
				$temp_cheque=array(
					'fecha'=>date('Y-m-d',strtotime($item['fecha'])),
					'bancoId'=>$item['banco_id'],
					'numero'=>$item['nro'],
					'importe'=>floatval($item['importe']),
					'estado'=>'AC',
					'observacion'=>null,
					'espropio'=>1,
					'tipo'=>2,
					'vencimiento'=>null,
					'agenteId'=>$data['agente_tomador_id']
				);
				$this->db->insert('cheques',$temp_cheque);
				$cheque_id=$this->db->insert_id();
				
				$operacion_detalle=array(
					'operacion_id'=>$operacion_id,
					'cheque_id'=>$cheque_id,
				);
				$this->db->insert('operacion_detalle',$operacion_detalle);
				$operacion_detalle_id=$this->db->insert_id();
			}
		}

		// Inserta Tranferencias de Salida
		if(isset($data['tranferencia_salida'])){			
			foreach($data['tranferencia_salida'] as $key=>$item){			
				
				$temp_transf= array(
					'banco_id' => $item['banco_id'],
					'cbu_nro' => (is_numeric($item['cbu']))?$item['cbu']:0,
					'cbu_alias' => (!is_numeric($item['cbu']))?$item['cbu']:'',
					'importe'=>floatval($item['importe']),
					'fecha'=>date('Y-m-d',strtotime($item['fecha'])),
					'estado' =>'AC'
				);

				$this->db->insert('transferencias',$temp_transf);
				$transferencia_id=$this->db->insert_id();
				
				$operacion_detalle=array(
					'operacion_id'=>$operacion_id,
					'transferencia_id'=>$transferencia_id,
				);
				$this->db->insert('operacion_detalle_transferencia',$operacion_detalle);
				$operacion_detalle_tranferencia_id=$this->db->insert_id();
				
			}
		}




		$this->db->trans_complete();
		return true;
	}

	public function setInvestor($data=null){
		if($data == null){
			return false;
		}
		else{

			$action = 	$data['act'];
			$id = 		$data['id'];

			$data_temp= array(
				'razon_social'=>$data['razon_social'],				
				'cuit'=>str_replace('-','',$data['cuit']),
				'domicilio'=>$data['domicilio'],
				'estado'=>$data['estado'],
			);
			
			switch($action){
				case 'Add':{
					$this->db->trans_start();
					//$this->db->set('created', 'NOW()', FALSE);
					//$this->db->set('updated', 'NOW()', FALSE);
					$result= $this->db->insert('inversor', $data_temp);
					echo $this->db->last_query();
					$idInvestor = $this->db->insert_id();
					$this->db->trans_complete();
					break;
				}
				case 'Edit':{
					$this->db->trans_start();
					if($this->db->update('inversor', $data_temp, array('id'=>$id)) == false) {
				 		return false;
				 	}
					$this->db->trans_complete();
					break;
				}
				default:{	
					break;
				}
			}

		}

		return true;
	}

	function printOperation($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$data['act'] = 'Print';
			$result = $this->getOperation($data);
			//Inversor
			$query= $this->db->get_where('inversor',array('id' => $result['operation']['inversor_id']));
			if ($query->num_rows() != 0)
			{
				$inversor = $query->result_array();
				$data['inversor'] = $inversor[0];
			}
			//Tenedor
			$query= $this->db->get_where('agente',array('id' => $result['operation']['agente_tenedor_id']));
			if ($query->num_rows() != 0)
			{
				$tenedor = $query->result_array();
				$data['tenedor'] = $tenedor[0];
			}
			//Banco
			$query= $this->db->get_where('banco',array('id' => $result['operation']['banco_id']));
			if ($query->num_rows() != 0)
			{
				$banco = $query->result_array();
				$data['banco'] = $banco[0];
			}
			//Emisor
			$query= $this->db->get_where('agente',array('id' => $result['operation']['agente_emisor_id']));
			if ($query->num_rows() != 0)
			{
				$emisor = $query->result_array();
				$data['emisor'] = $emisor[0];
			}
			//Detalle
			


			$html= '<table width="100%" style="font-family:Arial; font-size: 13pt;">';
			//Titulo
			$html.= '<tr><td style="text-align: center"><strong>CONTRATO DE MUTUO</td></tr>';
			//Header
			$html.= '<tr><td style="text-align:justify;">';
			$html.= 'Entre <strong>'.$data['inversor']['razon_social'].'</strong>, CUIT: <strong>';
			$html.= $data['inversor']['cuit'].'</strong> con domicilio legal en <strong>';
			$html.= $data['inversor']['domicilio'].'</strong>, denominado en adelante <strong> EL MUTUANTE </strong>, ';
			$html.= 'y <strong>'.$data['tenedor']['apellido'].', '.$data['tenedor']['nombre'].'</strong>, ';
			$html.= 'CUIT: <strong>'.$data['tenedor']['cuit'].'</strong>, con domicilio legal en <strong>';
			$html.= $data['tenedor']['domicilio'].'</strong>, en adelante <strong> EL MUTUARIO</strong>, ';
			$html.= 'convienen en celebrar el presente CONTRATO DE MUTUO, sujeto a las siguientes cláusulas: <br>';
			$html.= '</td></tr>';
			//Primera
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>PRIMERA:</strong> el MUTUANTE da en mutuo al MUTUARIO, quien lo acepta, ';
			$html.= 'la cantidad de ---------- - ( $ '.$result['operation']['neto'].' ), cuyo pago se efectua con ';
			$html.= 'cheque/s banco XXXXXXXX';
			$html.= '</td></tr>';
			//Cheques de pago 
			$html.= '<tr><td><br>';
			$html.= '<table width="100%" style="border: 1px solid #000;">';
			$html.= '<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Importe</th><th>Fecha</th></tr>';	
			$html.= '</td></tr></table>';
			//-----------------------------------------------------
			$html.= '<tr><td><br></td></tr>';
			//Segunda
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>SEGUNDA:</strong>';
			$html.= ' en el mismo acto, el MUTUARIO entrega al MUTUANTE chueques de pago diferido cuyo ';
			$html.= 'monto total, asciende a la suma de: -------------------------- - ( $ '.number_format($result['operation']['importe'], 2, ',', '.').' ) ';
			$html.= 'de acuerdo al detalle que figura en la planilla que se expone a continuación:';
			$html.= '</td></tr>';
			//Pagos
			$html.= '<tr><td><br>';
			$html.= '<table width="100%" style="border: 1px solid #000;">';
			$html.= '<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Firmante</th><th>Vencimiento</th><th>Importe</th></tr>';
			$html.= '<tr>';
			$html.= '<td>'.$data['banco']['razon_social'].'</td>';
			$html.= '<td style="text-align: right">'.$result['operation']['nro_cheque'].'</td>';
			$html.= '<td>'.$data['emisor']['apellido'] . ' ' . $data['emisor']['nombre'].'x</td>';
			$html.= '<td style="text-align: center">'.date("d-m-Y", strtotime($result['operation']['fecha_venc'])).'</td>';
			$html.= '<td style="text-align: right">'.number_format($result['operation']['importe'], 2, ',', '.').'</td>';
			$html.= '</td></tr></table>';
			//-----------------------------------------------------
			$html.= '<tr><td><br></td></tr>';
			//Tercera
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>TERCERA:</strong>';
			$html.= '  en caso de operarse el cobro efectivo de los valores referidos en la clausula ';
			$html.= 'anterior, el monto resultante de su percepción sera imputado por el MUTUANTE al ';
			$html.= 'pago del mutuo, segun la tasa de descuento convenida al momento de la firma del ';
			$html.= 'presente contrato.-';
			$html.= '</td></tr>';
			$html.= '<tr><td><br></td></tr>';
			//Cuarta
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>CUARTA:</strong>';
			$html.= ' en caso que, por cualquier circunstancia resultare necesario ejecutar judicialmente ';
			$html.= 'el incumplimiento de este contrato, las partes pactan que el MUTUARIO abonará un ';
			$html.= 'interés punitorio del 3% mensual, capitalizable mensualmente.-';
			$html.= '</td></tr>';
			$html.= '<tr><td><br></td></tr>';
			//Quinta
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>QUINTA:</strong>';
			$html.= ' el MUTUARIO declara bajo juramente que celebra este contrato de BUENA FE, manifestando ';
			$html.= 'que los cheques que entrega el MUTUANTE, no han sido obtenidos por medio de hechos ';
			$html.= 'ilicitos tales como el hurto y el robo, ni guardan vinculo alguno con maniobras ';
			$html.= 'fraudulentas, ni con maniobras de lavado de activos de origen criminal, ni con ';
			$html.= 'fondos que de algún modo pudieran ser empleados con propositos delictivos.-';
			$html.= '</td></tr>';
			$html.= '<tr><td><br></td></tr>';
			//Sexta
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>SEXTA:</strong>';
			$html.= ' las partes constituyen domicilios en los indicados en el comienzo, donde serán válidas ';
			$html.= 'las notificaciones que se cursen. En el caso de contienda judicieal se someten a los tribunales ';
			$html.= 'ordinarios de la provincia de San Juan.-';
			$html.= '</td></tr>';
			$html.= '<tr><td><br></td></tr>';
			//Septima
			$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>SEPTIMA:</strong>';
			$html.= ' De común acuerdo, las partes deciden certificar sus firmas ante notario público, '; 
			$html.= 'conforme lo dispuesto en el artículo 486, inc. 2 del C.P.C. de la Provincia de San Juan ';
			$html.= 'por lo cual el presente constituye título ejecutivo. En caso de accionarse judicialmente ';
			$html.= 'para obtener de tal modo el cobro de las obligaciones asumidas por el MUTUARIO, los ';
			$html.= 'valores entregados en pago por el MUTUARIO y este contrato constituiran un solo ';
			$html.= 'y único instrumento.-';
			$html.= '</td></tr>';
			$html.= '<tr><td><br></td></tr>';
			//Pie
			$html.= '<tr><td style="text-align:justify;"> En prueba de conformidad, se firman dos ejemplares ';
			$html.= 'de un mismo tenor y a un solo efecto, en San Juan a los xx días del mes de xxxxx de xxxx.-';
			$html.= '</td></tr>';
			$html.= '</table>';

			//se incluye la libreria de dompdf
			require_once("assets/plugin/HTMLtoPDF/dompdf/dompdf_config.inc.php");
			//se crea una nueva instancia al DOMPDF
			$dompdf = new DOMPDF();
			//se carga el codigo html
			$dompdf->load_html(utf8_decode($html));
			//aumentamos memoria del servidor si es necesario
			ini_set("memory_limit","300M");
			//Tamaño de la página y orientación
			$dompdf->set_paper('a4','portrait');
			//lanzamos a render
			$dompdf->render();
			//guardamos a PDF
			//$dompdf->stream("TrabajosPedndientes.pdf");
			$output = $dompdf->output();
			file_put_contents('assets/reports/'.$data['id'].'.pdf', $output);

			//Eliminar archivos viejos ---------------
			$dir = opendir('assets/reports/');
			while($f = readdir($dir))
			{
				if((time()-filemtime('assets/reports/'.$f) > 3600*24*1) and !(is_dir('assets/reports/'.$f)))
				unlink('assets/reports/'.$f);
			}
			closedir($dir);
			//----------------------------------------
			return $data['id'].'.pdf';
		}
    }
}
	
    