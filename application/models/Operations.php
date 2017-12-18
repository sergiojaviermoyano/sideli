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
				$result[$key]['tomador']=$tomador->row()->razon_social == '' ? $tomador->row()->nombre.", ".$tomador->row()->apellido : $tomador->row()->razon_social;
				
				
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

				//Inversor
				$query= $this->db->get_where('inversor',array('id' => $temp[0]['inversor_id']));
				if ($query->num_rows() != 0)
				{
					$inversor = $query->result_array();
					$data['inversor'] = $inversor[0];
				}
				//Tenedor
				$query= $this->db->get_where('agente',array('id' => $temp[0]['agente_tenedor_id']));
				if ($query->num_rows() != 0)
				{
					$tenedor = $query->result_array();
					$data['tenedor'] = $tenedor[0];
				}
				//Banco
				$query= $this->db->get_where('banco',array('id' => $temp[0]['banco_id']));
				if ($query->num_rows() != 0)
				{
					$banco = $query->result_array();
					$data['banco'] = $banco[0];
				}
				//Emisor
				$query= $this->db->get_where('agente',array('id' => $temp[0]['agente_emisor_id']));
				if ($query->num_rows() != 0)
				{
					$emisor = $query->result_array();
					$data['emisor'] = $emisor[0];
				}

				//---------------------
				//Get Cheques 
				$cheques = array();
				$this->db->select('cheques.*');
				$this->db->from('cheques');
				$this->db->join('operacion_detalle', 'operacion_detalle.cheque_id = cheques.id');;
				$this->db->where(array('operacion_detalle.operacion_id' => $data['operation']['id'], 'cheques.tipo' => 2));
				$query = $this->db->get();
				//echo $this->db->last_query();
				if ($query->num_rows() != 0)
				{
					foreach($query->result() as $che)
					{
						$cheques[] = array(
											$this->getBankName($che->bancoId), 
											$che->numero,
											number_format($che->importe, 2, ',', '.'),
											date("d-m-Y", strtotime($che->fecha))
										);
					}
					
				}	
				$data['cheques'] = $cheques;
				//Get Transferencias
				$transferencias = array();
				$this->db->select('transferencias.*');
				$this->db->from('transferencias');
				$this->db->join('operacion_detalle_transferencia', 'operacion_detalle_transferencia.transferencia_id = transferencias.id');;
				$this->db->where(array('operacion_detalle_transferencia.operacion_id' => $data['operation']['id']));
				$query = $this->db->get();
				//echo $this->db->last_query();
				if ($query->num_rows() != 0)
				{
					foreach($query->result() as $che)
					{
						$transferencias[] = array(
											$this->getBankName($che->banco_id), 
											$che->cbu_alias,
											number_format($che->importe, 2, ',', '.'),
											date("d-m-Y", strtotime($che->fecha))
										);
					}
					
				}
				$data['transferencias'] = $transferencias;
				//---------------------
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
			$data['act'] = $action;
           
			return $data;
		}

	}


	public function add($data=false){
		
		// Consulta si existe Agente Emisor por nro cuit, si no existe lo agrega
		$get_agente=$this->db->get_where('agente',array('cuit'=>$data['emisor_cuit']));
		if($get_agente->num_rows()==0){		
		
			$agente_emisor= array(
				'nombre'=>$data['emisor_razon_social'],
				'apellido'=>'',
				'cuit'=>$data['emisor_cuit'],
				'razon_social'=>$data['emisor_razon_social'],
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
			if(!file_exists( 'assets/reports/'.$data['id'].'.pdf' )){
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
				$html.= 'y <strong>'.($data['tenedor']['razon_social'] == '' ? $data['tenedor']['apellido'].', '.$data['tenedor']['nombre'] : $data['tenedor']['razon_social']).'</strong>, ';
				$html.= 'CUIT: <strong>'.$data['tenedor']['cuit'].'</strong>, con domicilio legal en <strong>';
				$html.= $data['tenedor']['domicilio'].'</strong>, en adelante <strong> EL MUTUARIO</strong>, ';
				$html.= 'convienen en celebrar el presente CONTRATO DE MUTUO, sujeto a las siguientes cláusulas: <br>';
				$html.= '</td></tr>';
				//Primera
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>PRIMERA:</strong> el MUTUANTE da en mutuo al MUTUARIO, quien lo acepta, ';
				$html.= 'la cantidad de pesos '.$this->convertNumber($result['operation']['neto']).' - ( $ '.number_format($result['operation']['neto'], 2, ',', '.').' ), cuyo pago se efectua con :';
				//$html.= 'cheque/s banco XXXXXXXX';
				$html.= '</td></tr>';
				//Cheques de pago 
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				//Get Cheques 
				$this->db->select('cheques.*');
				$this->db->from('cheques');
				$this->db->join('operacion_detalle', 'operacion_detalle.cheque_id = cheques.id');;
				$this->db->where(array('operacion_detalle.operacion_id' => $result['operation']['id'], 'cheques.tipo' => 2));
				$query = $this->db->get();
				if ($query->num_rows() != 0 && $query->num_rows() > 1)
				{
					$html.= '<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Importe</th><th>Fecha</th></tr>';	
					foreach($query->result() as $che)
					{
						$html.= '<tr>';
						$html.= 	'<td>'.$this->getBankName($che->bancoId).'</td>';
						$html.= 	'<td style="text-align: right">'.$che->numero.'</td>';
						$html.= 	'<td style="text-align: right">'.number_format($che->importe, 2, ',', '.').'</td>';
						$html.= 	'<td style="text-align: center">'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html.= '</tr>';
					}
					
				}
				//Get Transferencias
				$this->db->select('transferencias.*');
				$this->db->from('transferencias');
				$this->db->join('operacion_detalle_transferencia', 'operacion_detalle_transferencia.transferencia_id = transferencias.id');;
				$this->db->where(array('operacion_detalle_transferencia.operacion_id' => $result['operation']['id']));
				$query = $this->db->get();
				if ($query->num_rows() != 0)
				{
					$html.= '<tr style="text-align: center"><th>Banco</th><th>CBU/Alias</th><th>Importe</th><th>Fecha</th></tr>';	
					foreach($query->result() as $che)
					{
						$html.= '<tr>';
						$html.= 	'<td>'.$this->getBankName($che->banco_id).'</td>';
						$html.= 	'<td style="text-align: right">'.$che->cbu_alias.'</td>';
						$html.= 	'<td style="text-align: right">'.number_format($che->importe, 2, ',', '.').'</td>';
						$html.= 	'<td style="text-align: center">'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html.= '</tr>';
					}
					
				}
				$html.= '</table></td></tr>';
				//-----------------------------------------------------
				$html.= '<tr><td><br></td></tr>';
				//Segunda
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>SEGUNDA:</strong>';
				$html.= ' en el mismo acto, el MUTUARIO entrega al MUTUANTE chueques de pago diferido cuyo ';
				$html.= 'monto total, asciende a la suma de: pesos '.$this->convertNumber($result['operation']['importe']).' - ( $ '.number_format($result['operation']['importe'], 2, ',', '.').' ) ';
				$html.= 'de acuerdo al detalle que figura en la planilla que se expone a continuación:';
				$html.= '</td></tr>';
				//Pagos
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				$html.= '<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Firmante</th><th>Vencimiento</th><th>Importe</th></tr>';
				$html.= '<tr>';
				$html.= '<td>'.$data['banco']['razon_social'].'</td>';
				$html.= '<td style="text-align: right">'.$result['operation']['nro_cheque'].'</td>';
				$html.= '<td>'.($data['emisor']['razon_social'] == '' ? $data['emisor']['apellido'] . ' ' . $data['emisor']['nombre'] : $data['emisor']['razon_social']).'</td>';
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
				$dateTime = explode(' ', $result['operation']['created']);
				$date = explode('-', $dateTime[0]);
				$html.= 'de un mismo tenor y a un solo efecto, en San Juan a los '.str_pad($date[2], 2, "0", STR_PAD_LEFT).' días del mes de '.$this->getMonth($date[1]).' de '.$date[0].'.-';
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
			}
			return $data['id'].'.pdf';
		}
    }

    function getMonth($monthNumber){
    	switch ($monthNumber) {
    		case '01':
    			return 'Enero';
    			break;
    		case '02':
    			return 'Febrero';
    			break;
    		case '03':
    			return 'Marzo';
    			break;
    		case '04':
    			return 'Abril';
    			break;
    		case '05':
    			return 'Mayo';
    			break;
    		case '06':
    			return 'Junio';
    			break;
    		case '07':
    			return 'Julio';
    			break;
    		case '08':
    			return 'Agosto';
    			break;
    		case '09':
    			return 'Septiembre';
    			break;
    		case '10':
    			return 'Octubre';
    			break;
    		case '11':
    			return 'Noviembre';
    			break;
    		case '12':
    			return 'Diciembre';
    			break;
    		
    		default:	
    			return '-';
    			break;
    	}
    }

    function getBankName($id){
    	$query= $this->db->get_where('banco',array('id' => $id));
		if ($query->num_rows() != 0)
		{
			$banco = $query->result_array();
			return $banco[0]['razon_social'];
		} else {
			return '-';
		}
    }

    //*******
	function convertNumber($number)
	{
	    list($integer, $fraction) = explode(".", (string) $number);

	    $output = "";

	    if ($integer{0} == "-")
	    {
	        $output = "negative ";
	        $integer    = ltrim($integer, "-");
	    }
	    else if ($integer{0} == "+")
	    {
	        $output = "positive ";
	        $integer    = ltrim($integer, "+");
	    }

	    if ($integer{0} == "0")
	    {
	        $output .= "zero";
	    }
	    else
	    {
	        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
	        $group   = rtrim(chunk_split($integer, 3, " "), " ");
	        $groups  = explode(" ", $group);

	        $groups2 = array();
	        foreach ($groups as $g)
	        {
	            $groups2[] = $this->convertThreeDigit($g{0}, $g{1}, $g{2});
	        }

	        for ($z = 0; $z < count($groups2); $z++)
	        {
	            if ($groups2[$z] != "")
	            {
	                $output .= $groups2[$z] . $this->convertGroup(11 - $z) . (
	                        $z < 11
	                        && !array_search('', array_slice($groups2, $z + 1, -1))
	                        && $groups2[11] != ''
	                        && $groups[11]{0} == '0'
	                            ? " and "
	                            : ", "
	                    );
	            }
	        }

	        $output = rtrim($output, ", ");
	    }

	    if ($fraction > 0)
	    {
	        $output .= " con ".$this->convertTwoDigit($fraction[0], $fraction[1])." centavos";

	        //for ($i = 0; $i < strlen($fraction); $i++)
	        //{
	        //    $output .= " " . $this->convertDigit($fraction{$i});
	        //}
	    }

	    return $output;
	}

	function convertGroup($index)
	{
	    switch ($index)
	    {
	        case 11:
	            return " decillón";
	        case 10:
	            return " nonillón";
	        case 9:
	            return " octillón";
	        case 8:
	            return " septillón";
	        case 7:
	            return " sextillón";
	        case 6:
	            return " quintrillón";
	        case 5:
	            return " quadrillón";
	        case 4:
	            return " trillón";
	        case 3:
	            return " billón";
	        case 2:
	            return " millón";
	        case 1:
	            return " mil";
	        case 0:
	            return "";
	    }
	}

	function convertThreeDigit($digit1, $digit2, $digit3)
	{
	    $buffer = "";

	    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
	    {
	        return "";
	    }

	    if ($digit1 != "0" )
	    {

	    	if($digit1 != "1")
	        	$buffer .= $this->convertDigit($digit1) . "cien";
	        else
	        	$buffer .= "cien";
	        if ($digit2 != "0" || $digit3 != "0")
	        {
	        	if($digit1 != "1")
		        	$buffer .= "tos ";
		        else
		        	$buffer .= "to ";
	        }
	    }

	    if ($digit2 != "0")
	    {
	        $buffer .= $this->convertTwoDigit($digit2, $digit3);
	    }
	    else if ($digit3 != "0")
	    {
	        $buffer .= $this->convertDigit($digit3);
	    }

	    return $buffer;
	}

	function convertTwoDigit($digit1, $digit2)
	{
	    if ($digit2 == "0")
	    {
	        switch ($digit1)
	        {
	            case "1":
	                return "diez";
	            case "2":
	                return "veinte";
	            case "3":
	                return "treinta";
	            case "4":
	                return "cuarenta";
	            case "5":
	                return "cincuenta";
	            case "6":
	                return "sesenta";
	            case "7":
	                return "setenta";
	            case "8":
	                return "ochenta";
	            case "9":
	                return "noventa";
	        }
	    } else if ($digit1 == "1")
	    {
	        switch ($digit2)
	        {
	            case "1":
	                return "once";
	            case "2":
	                return "doce";
	            case "3":
	                return "trece";
	            case "4":
	                return "catorce";
	            case "5":
	                return "quince";
	            case "6":
	                return "dieciséis";
	            case "7":
	                return "diecisiete";
	            case "8":
	                return "dieciocho";
	            case "9":
	                return "diecinueve";
	        }
	    } else
	    {
	        $temp = $this->convertDigit($digit2);
	        switch ($digit1)
	        {
	            case "2":
	                return "veinti$temp";
	            case "3":
	                return "treinta y $temp";
	            case "4":
	                return "cuarenta y $temp";
	            case "5":
	                return "cincuenta y $temp";
	            case "6":
	                return "sesenta y $temp";
	            case "7":
	                return "setenta y $temp";
	            case "8":
	                return "ochenta y $temp";
	            case "9":
	                return "noventa y $temp";
	        }
	    }
	}

	function convertDigit($digit)
	{
	    switch ($digit)
	    {
	        case "0":
	            return "cero";
	        case "1":
	            return "un";
	        case "2":
	            return "dos";
	        case "3":
	            return "tres";
	        case "4":
	            return "cuatro";
	        case "5":
	            return "cinco";
	        case "6":
	            return "séis";
	        case "7":
	            return "siete";
	        case "8":
	            return "ocho";
	        case "9":
	            return "nueve";
	    }
	}
    //*******

    function printLiquidacion($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			if(!file_exists( 'assets/reports/'.$data['id'].'_l.pdf' )){
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
				$html.= '<tr><td style="text-align: right"><strong>'.$data['inversor']['razon_social'].'</td></tr>';
				//Header
				$html.= '<tr><td style="text-align:left;"><strong>LIQUIDACIÓN DE VALORES</strong></td></tr>';
				$html.= '<tr><td style="text-align:right;"><strong>FECHA: '.date("d-m-Y", strtotime($result['operation']['created'])).'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">CLIENTE: <strong>'. ($data['tenedor']['razon_social'] == '' ? $data['tenedor']['apellido'].', '.$data['tenedor']['nombre'] : $data['tenedor']['razon_social']).'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">DOMICILIO: <strong>'.$data['tenedor']['domicilio'].'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">CUIT: <strong>'.$data['tenedor']['cuit'].'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">FACTURA NÚMERO: <strong>'.str_pad($data['id'], 10, "0", STR_PAD_LEFT).'</strong></td></tr>';
				$html.= '<tr><td style="text-align:center; text-decoration: underline;">DETALLE DE VALORES COMPRADOS</td></tr>';
				//Cheque recibido
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				$html.= '<tr style="text-align: center"><th>BANCO</th><th>NUMERO</th><th>LIBRADOR</th><th>F.PAGO</th><th>TASA</th><th>DIAS</th><th>IMPORTE $</th></tr>';
				$html.= '<tr>';
				$html.= '<td>'.$data['banco']['razon_social'].'</td>';
				$html.= '<td style="text-align: right">'.$result['operation']['nro_cheque'].'</td>';
				$html.= '<td>'.$data['emisor']['apellido'] . ' ' . $data['emisor']['nombre'].'</td>';
				$html.= '<td style="text-align: center">'.date("d-m-Y", strtotime($result['operation']['fecha_venc'])).'</td>';
				$html.= '<td style="text-align: right">'.number_format($result['operation']['tasa_mensual'], 2, ',', '.').'</td>';
				$html.= '<td style="text-align: right">'.number_format($result['operation']['nro_dias'], 0, ',', '.').'</td>';
				$html.= '<td style="text-align: right">'.number_format($result['operation']['importe'], 2, ',', '.').'</td>';
				$html.= '</td></tr></table></td></tr>';
				//Detalle
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">TOTAL DE VALORES $</td><td style="text-align:right">'.number_format($result['operation']['importe'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">INTERESES $</td><td style="text-align:right">'.number_format($result['operation']['interes'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">IMP DEB Y CRED BANCARIOS $</td><td style="text-align:right">'.number_format($result['operation']['impuesto_cheque'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">VALORES OTRA PLAZA $</td><td style="text-align:right">'.number_format($result['operation']['gastos'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">COMISIONES $</td><td style="text-align:right">'.number_format($result['operation']['comision_total'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">IVA $</td><td style="text-align:right">'.number_format($result['operation']['iva'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">SELLADO $</td><td style="text-align:right">'.number_format($result['operation']['sellado'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left">NETO A LIQUIDAR $</td><td style="text-align:right">'.number_format($result['operation']['neto'], 2, ',', '.').'</td></tr>';
				$html.= '</table></tr></td>';
				//Foother
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;">';
				$html.= 'El Pago de IVA y sellado, es abonado al momento de liquidación de la operación.-</td></tr> ';
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;">';
				$html.= 'RECIBI IMPORTE NETO LIQUIDADO CON <br> ';
				//Cheques de pago 
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				//Get Cheques 
				$this->db->select('cheques.*');
				$this->db->from('cheques');
				$this->db->join('operacion_detalle', 'operacion_detalle.cheque_id = cheques.id');;
				$this->db->where(array('operacion_detalle.operacion_id' => $result['operation']['id'], 'cheques.tipo' => 2));
				$query = $this->db->get();
				if ($query->num_rows() != 0 && $query->num_rows() > 1)
				{
					$html.= '<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Importe</th><th>Fecha</th></tr>';	
					foreach($query->result() as $che)
					{
						$html.= '<tr>';
						$html.= 	'<td>'.$this->getBankName($che->bancoId).'</td>';
						$html.= 	'<td style="text-align: right">'.$che->numero.'</td>';
						$html.= 	'<td style="text-align: right">'.number_format($che->importe, 2, ',', '.').'</td>';
						$html.= 	'<td style="text-align: center">'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html.= '</tr>';
					}
					
				}
				//Get Transferencias
				$this->db->select('transferencias.*');
				$this->db->from('transferencias');
				$this->db->join('operacion_detalle_transferencia', 'operacion_detalle_transferencia.transferencia_id = transferencias.id');;
				$this->db->where(array('operacion_detalle_transferencia.operacion_id' => $result['operation']['id']));
				$query = $this->db->get();
				if ($query->num_rows() != 0)
				{
					$html.= '<tr style="text-align: center"><th>Banco</th><th>CBU/Alias</th><th>Importe</th><th>Fecha</th></tr>';	
					foreach($query->result() as $che)
					{
						$html.= '<tr>';
						$html.= 	'<td>'.$this->getBankName($che->banco_id).'</td>';
						$html.= 	'<td style="text-align: right">'.$che->cbu_alias.'</td>';
						$html.= 	'<td style="text-align: right">'.number_format($che->importe, 2, ',', '.').'</td>';
						$html.= 	'<td style="text-align: center">'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html.= '</tr>';
					}
					
				}
				$html.= '</table></td></tr>';
				//-----------------------------------------------------
				//Listado de cheuqes emitidos 
				$html.= '</td></tr>';
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>';
				$html.= 'ESTA OPERACION SE CANCELA CON CHUEQUE '.$data['banco']['razon_social'].' N'.$result['operation']['nro_cheque'].'</td></tr>';
				//Firmas
				$html.= '<tr><td><br><br><br><br><br><br><br><br>';
				$html.= '<table width="100%">';
				$html.= '<tr><td style="width: 50%; text-align:center;">'.$data['inversor']['razon_social'].'</td><td style="width: 50%; text-align:center;">'.$data['tenedor']['apellido'].', '.$data['tenedor']['nombre'].'</td></tr>';
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
				$output = $dompdf->output();
				file_put_contents('assets/reports/'.$data['id'].'_l.pdf', $output);
			}
			return $data['id'].'_l.pdf';
		}
    }
}
	
    