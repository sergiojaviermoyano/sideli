<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Operations extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//$this->add_column();
		$this->create_log_table();
	}
	public function create_log_table(){
		$this->load->dbforge();    
		$this->dbforge->add_field('id');
		$this->dbforge->add_field(array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'DEFAULT' =>0
            ),            
            'operacion_id' => array(  /// Monto SOlicitado
				'type' => 'INT',
                'constraint' => 11,
                'DEFAULT' =>0
            ),
            'comment' => array( //Nro de Cuotas a pagar
				'type' => 'TEXT',
                'DEFAULT' =>NULL
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => '1',
                'DEFAULT' =>0
            ),
            'date_added' => array(
				'type' => 'DATETIME',
            ),
        ));        
        $this->dbforge->create_table('operacion_log',true);
	}
	function add_column(){
		$sql="SELECT * FROM `operacion` LIMIT 1" ;
		$query=$this->db->query($sql);
		$check=false;
		foreach($query->result_array() as $item){
			if(!isset($item['factura_tipo'])){
				$check=true;
				break;
			}
		}
		if($check){

			$sql='ALTER TABLE `operacion`
			ADD COLUMN  `factura_tipo` VARCHAR(2) NULL DEFAULT NULL AFTER `observacion`,
			ADD COLUMN  `factura_nro` VARCHAR(11) NULL DEFAULT NULL AFTER `factura_tipo`;';
			
			$this->db->query($sql);
		}
		return true;
		
	}

	function List_all($estado=false,$padres=false){
		if($estado){
			$this->db->where("estado",$estado);
		}

		$this->db->where("estado!=",2);
		/*if($padres){
			$this->db->where("operacion_padre=",0);
		}*/
		
		$this->db->order_by('id', 'DESC');
		$query= $this->db->get('operacion');
		
		
		if ($query->num_rows()!=0)
		{
			$result=$query->result_array();

			foreach($result as $key=>$item){
				//$banco=$this->db->get_where('banco',array('id'=>$item['banco_id']));				
				//$result[$key]['banco']='';//$banco->row()->razon_social;

				$tomador=$this->db->get_where('agente',array('id'=>$item['agente_tenedor_id']));				
				$result[$key]['tomador']=$tomador->row()->razon_social == '' ? $tomador->row()->nombre."  ".$tomador->row()->apellido : $tomador->row()->razon_social;
				
				
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
			if ($query->num_rows() != 0){	

				$this->addlog($id,'Abre Operacíon');
				$temp=$query->row_array();	
				
				$data['operation'] = $temp;
				$detalle_operacion=$this->db->query("select od.*,
				(select razon_social from banco where id = od.banco_id) as 'banco_nombre',
				(select razon_social from agente where id = od.emisor_id) as 'agente_razon_social',
				(select CONCAT(nombre,' ',apellido) from agente where id = od.emisor_id) as 'agente_nombre_apellido',
				c.tipo as tipo 
				from operacion_detalle as od INNER JOIN cheques as c ON od.cheque_id = c.id where od.operacion_id='".$id."';");
				
				if($detalle_operacion->num_rows()!=0){
					$data['detalle_operacion']= $detalle_operacion->result_array();					
				}

				//Inversor
				$query= $this->db->get_where('inversor',array('id' => $temp['inversor_id']));
				if ($query->num_rows() != 0)
				{
					$inversor = $query->row_array();
					$data['inversor'] = $inversor;
				}
				//Tenedor
				$query= $this->db->get_where('agente',array('id' => $temp['agente_tenedor_id']));
				if ($query->num_rows() != 0)
				{
					$tenedor = $query->row_array();
					$data['tenedor'] = $tenedor;
				}
				//Banco
				$query= $this->db->get_where('banco',array('id' => $temp['banco_id']));
				if ($query->num_rows() != 0)
				{
					$banco = $query->row_array();
					$data['banco'] = $banco;
				}
				//Emisor
				$query= $this->db->get_where('agente',array('id' => $temp['agente_emisor_id']));
				if ($query->num_rows() != 0)
				{
					$emisor = $query->row_array();
					$data['emisor'] = $emisor;
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

	public function add($data = false){
		
		$this->db->trans_start();	

		if(!isset($data['tomador'])){
			$error = array('error'=>'tomador','message'=>'No se envio Datos de Tomador');
			return $error;
		}
		
		
		$operation_data = array();
		$tomador_id=0;
		$get_agente=$this->db->get_where('agente',array('cuit'=>$data['tomador']['cuit']));
		
		if($get_agente->num_rows()==0){	
			$agente_tomador= array(
				'nombre'=>$data['tomador']['razon_social'],
				'apellido'=>'',
				'cuit'=>$data['tomador']['cuit'],
				'razon_social'=>$data['tomador']['razon_social'],
				'domicilio'=>'',
				'tipo'=>2,
				'estado'=>'ac',
			);					
			
			$this->db->set('created', 'NOW()', FALSE);
			$this->db->set('updated', 'NOW()', FALSE);
			$result= $this->db->insert('agente', $agente_tomador);
			$tomador_id = $this->db->insert_id();
			
		}else{
			$tomador_id = $data['tomador']['id'];
		}

		$operation_params=array(
			'agente_tenedor_id'=>$tomador_id,			
			'inversor_id'=>$data['inversor_id'],
			'observacion'=>$data['observacion'],
			'neto'=>$data['neto_final'],
			'estado'=>0,
			'created'=>date('Y-m-d h:m:i'),			
		);

		$operacion_result= $this->db->insert('operacion', $operation_params);
		$operacion_id = $this->db->insert_id();
		$this->addlog($operacion_id,'Crea Operacion');
		$operation_totals=array();
		foreach($data['emisor'] as $key => $emisor){
			
			if(!$this->existe_agente($emisor['cuit'])){
				$emisor_id = $this->agrega_agente($emisor);
			}else{
				$emisor_id = $emisor['id'];	
			}
			
			foreach($emisor['cheque'] as $chKey=>$cheque){
				$importe=str_replace('$','',$cheque['importe']);				

				$cheque_params=array(
					'fecha'=>date('Y-m-d',strtotime($cheque['fecha'])),
					'bancoId'=>$cheque['banco_id'],
					'numero'=>$cheque['nro'],
					'importe'=>floatval($importe),
					'estado'=>'AC',
					'observacion'=>null,
					'espropio'=>1,
					'tipo'=>1,
					'vencimiento'=>null,
					'agenteId'=>$emisor_id
				);
				$this->db->insert('cheques',$cheque_params);
				$cheque_id=$this->db->insert_id();
				
				$this->addlog($operacion_id,'Operacion: '.$operacion_id.' Compra Cheque:'.$cheque['nro'].' del Banco: '.$cheque['banco_id'].' ');
				$operacion_detalle=array(
					'operacion_id'=>$operacion_id,
					'cheque_id'=>$cheque_id,
					'emisor_id'=>$emisor_id,
					'banco_id'=>$cheque['banco_id'],
					'nro_cheque'=>$cheque['nro'],
					'importe'=>floatval($importe),
					'fecha_venc'=>date('Y-m-d',strtotime($cheque['fecha'])),
					'nro_dias'=>$cheque['dias'],
					'tasa_mensual'=>floatval($cheque['tasa_mensual']),
					'interes'=>floatval($cheque['interes']),
					'impuesto_cheque'=>($cheque['impuesto']),
					'gastos'=>floatval($cheque['gasto']),
					'compra'=>floatval($cheque['compra']),
					'comision_valor'=>floatval($cheque['comision_porcentaje']),
					'comision_total'=>floatval($cheque['comision_importe']),
					'subtotal'=>floatval('0'),
					'iva'=>floatval($cheque['iva']),
					'sellado'=>floatval($cheque['sellado']),
					'neto'=>floatval($cheque['neto']),
				);
				
				$this->db->insert('operacion_detalle',$operacion_detalle);
				
				$operacion_detalle_id=$this->db->insert_id();	
				$this->addlog($operacion_id,'Operacion: '.$operacion_id.' Con detalle de Operacíon:'.$operacion_detalle_id.' del Datos: '.serialize($operacion_detalle).' ');

				$operation_totals[]=$operacion_detalle;
			}
			
		}

		
		
		
		$operation_params=array(
			'importe'=>0,	
			'tasa_mensual'=>0,
			'interes'=>0,
			'impuesto_cheque'=>0,
			'gastos'=>0,
			'compra'=>0,
			'comision_valor'=>0,
			'comision_total'=>0,
			'subtotal'=>0,
			'iva'=>0,
			'sellado'=>0,
			'neto'=>0,
		);

		foreach($operation_totals  as $details){
			
			$operation_params['importe']+=$details['importe'];
			$operation_params['tasa_mensual']+=0;//$details['tasa_mensual'];
			$operation_params['interes']+=$details['interes'];
			$operation_params['impuesto_cheque']+=$details['impuesto_cheque'];
			$operation_params['gastos']+=$details['gastos'];
			$operation_params['compra']+=$details['compra'];
			$operation_params['comision_valor']+=$details['comision_valor'];
			$operation_params['comision_total']+=$details['comision_total'];
			$operation_params['subtotal']+=$details['subtotal'];
			$operation_params['iva']+=$details['iva'];
			$operation_params['sellado']+=$details['sellado'];
			$operation_params['neto']+=$details['neto'];

		}
		

		$this->db->where('id', $operacion_id);
		$this->db->update('operacion', $operation_params); 
		$this->addlog($operacion_id,'Operacion: '.$operacion_id.'Actualizada  Datos: '.serialize($operation_params).' ');


		if(isset($data['cheque_salida'])){	
			foreach($data['cheque_salida'] as $key => $cheque_salida){

				$temp_cheque=array(
					'fecha'=>date('Y-m-d',strtotime($cheque_salida['fecha'])),
					'bancoId'=>$cheque_salida['banco_id'],
					'numero'=>$cheque_salida['nro'],
					'importe'=>floatval($cheque_salida['importe']),
					'estado'=>'AC',
					'observacion'=>null,
					'espropio'=>1,
					'tipo'=>2,
					'vencimiento'=>null,
					'agenteId'=>$tomador_id
				);
				$this->db->insert('cheques',$temp_cheque);
				$cheque_id=$this->db->insert_id();
				$operacion_detalle=array(
					'operacion_id'=>$operacion_id,
					'cheque_id'=>$cheque_id,
					'emisor_id'=>$tomador_id,
					'banco_id'=>$cheque_salida['banco_id'],
					'nro_cheque'=>$cheque_salida['nro'],
					'importe'=>floatval($cheque_salida['importe']),
					'fecha_venc'=>date('Y-m-d',strtotime($cheque_salida['fecha'])),
					'nro_dias'=>1,
				);
				$this->db->insert('operacion_detalle',$operacion_detalle);
				$operacion_detalle_id=$this->db->insert_id();
				$this->addlog($operacion_id,'Operacion: '.$operacion_id.' Paga con cheques['.$cheque_id.']:'.$cheque_salida['nro'].': '.serialize($operacion_detalle).' ');

			}


			
		}

		// Inserta Tranferencias de Salida
		if(isset($data['transferencia_salida'])){			
			foreach($data['transferencia_salida'] as $key=>$item){			
				
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

	public function delete($data){
		
		$this->db->where('id', $data['id']);		
		if($this->db->update('operacion', array('estado'=>2))){
			$this->addlog($data['id'],'Operacion: '.$data['id'].' fue eliminada por '.$data['razon'].', Comentario: '.$data['comment'].' ');
			return true;
		}else{
			$this->addlog($data['id'],'Operacion: '.$data['id'].' Error al intentar elimnar Operacion por '.$data['razon'].', Comentario: '.$data['comment'].' ');
			return false;
		}

	}


	private function existe_agente($cuit=''){
		//var_dump("==> CUIT: ".$cuit);
		$query=$this->db->get_where('agente',array('cuit'=>$cuit));
		return ($query->num_rows()!=0);
	}
	private function agrega_agente($data,$type=1){

	}
	public function add_old($data=false){
		
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
		$importe=str_replace('$','',$data['importe']);
		$importe=str_replace('.','',$importe);
		$importe=str_replace(',','.',$importe);
		$params=array(
			'agente_emisor_id'=>$data['agente_emisor_id'],
			'agente_tenedor_id'=>$data['agente_tomador_id'],
			'banco_id'=>$data['banco_id'],
			'nro_cheque'=>$data['nro_cheque'],
			'importe'=>floatval($importe),
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
			'importe'=>floatval($importe),
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

		//INSERTA VARIOS CHEQUES
		if(isset($data['cheche_in'])){
			foreach($data['cheche_in'] as $key=>$item){

				$importe=str_replace('$','',$item['importe']);
				$importe=str_replace('.','',$importe);
				$importe=str_replace(',','.',$importe);
				
				$cheque_in=array(
					'fecha'=>date('Y-m-d'),
					'bancoId'=>$item['banco_id'],
					'numero'=>$item['nro'],
					'importe'=>floatval($importe),
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
			}	
		}
		//FIN INSERTA VARIOS CHEQUES

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
			$id= $data['id'];

			if(!file_exists( 'assets/reports/'.$data['id'].'.pdf' )){
				$data['act'] = 'Print';
				
				$result = $this->getOperation($data);

				

				$detalle_operacion=$this->db->query("select od.*,
				(select razon_social from banco where id = od.banco_id) as 'banco_nombre',
				(select razon_social from agente where id = od.emisor_id) as 'agente_razon_social',
				(select CONCAT(nombre,' ',apellido) from agente where id = od.emisor_id) as 'agente_nombre_apellido',
				c.tipo as tipo 
				from operacion_detalle as od INNER JOIN cheques as c ON od.cheque_id = c.id where od.operacion_id='".$id."';");
				
				if($detalle_operacion->num_rows()!=0){
					$data['detalle_operacion']= $detalle_operacion->result_array();					
				}
				
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
				


				$html= '<table width="100%" style="font-family:Arial; font-size: 12pt;">';
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
				$html.= 'la cantidad de pesos '.$this->convertNumber($result['operation']['neto']).' - ( $ '.number_format($result['operation']['neto'], 2, ',', '.').' ), cuyo pago se efectua con : ';
				//$html.= 'cheque/s banco XXXXXXXX';
				
				$html.= '</td></tr>';
				//Cheques de pago 
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				$html.= '<thead>';
				$html.= '<tr style="text-align: center;">';
				$html.= '<th style="text-align: center;">Banco</th><th style="text-align: center;">Cheque Nº</th><th style="text-align: center;">Importe</th><th style="text-align: center;">Fecha</th>';
				$html.= '</tr>';
				$html.= '</thead>';
				
				//Get Cheques 
				$this->db->select('cheques.*, (SELECT banco.razon_social FROM banco where banco.id = `cheques`.bancoId  ) as banco_nombre');
				$this->db->from('cheques');
				$this->db->join('operacion_detalle', 'operacion_detalle.cheque_id = cheques.id');;
				$this->db->where(array('operacion_detalle.operacion_id' => $result['operation']['id'], 'cheques.tipo' => 2));
				$query = $this->db->get();
				
				foreach($query->result() as $che)
				{
					$html.= '<tr>';
					$html.= 	'<td style="text-align: center">'.$che->banco_nombre.'</td>';
					$html.= 	'<td style="text-align: center">'.$che->numero.'</td>';
					$html.= 	'<td style="text-align: center"> $'.number_format($che->importe, 2, ',', '.').'</td>';
					$html.= 	'<td style="text-align: center">'.date("d-m-Y", strtotime($che->fecha)).'</td>';
					$html.= '</tr>';
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
						$html.= 	'<td style="text-align: center">'.$this->getBankName($che->banco_id).'</td>';
						if($che->cbu_nro!='' && $che->cbu_nro!=0){
							$html.= 	'<td style="text-align: center"> '.($che->cbu_nro).' </td>';
						}else{
							$html.= 	'<td style="text-align: center"> '.($che->cbu_alias).' </td>';
						}
						
						$html.= 	'<td style="text-align: center">'.number_format($che->importe, 2, ',', '.').'</td>';
						$html.= 	'<td style="text-align: center">'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html.= '</tr>';
					}
					
				}
				$html.= '</table></td></tr>';
				
				//-----------------------------------------------------
				$html.= '<tr><td><br></td></tr>';
				//Segunda
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><strong>SEGUNDA:</strong>';
				$html.= ' en el mismo acto, el MUTUARIO entrega al MUTUANTE cheque/s de pago diferido cuyo ';
				$html.= 'monto total, asciende a la suma de: pesos '.$this->convertNumber($result['operation']['importe']).' - ( $ '.number_format($result['operation']['importe'], 2, ',', '.').' ) ';
				$html.= 'de acuerdo al detalle que figura en la planilla que se expone a continuación:';
				$html.= '</td></tr>';

				
				
				//Pagos
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				$html.= '<thead>';
				$html.= '<tr style="text-align: center">';
				$html.= '<th >Banco</th><th>Número</th><th>Firmante</th><th>Vencimiento</th><th>Importe</th>';
				$html.= '</tr>';				
				$html.= '</thead>';
				$html.= '<tbody>';
				foreach($data['detalle_operacion'] as $detalle){
					if($detalle['tipo']==1){
						$html.='<tr style="text-align: center">';
						$html.= '<td>'.$detalle['banco_nombre'].'</td>'; 
						$html.= '<td>'.$detalle['nro_cheque'].'</td>'; 
						$html.= '<td>'.(($detalle['agente_razon_social']!='')?$detalle['agente_razon_social']:$detalle['agente_nombre_apellido']).'</td>'; 
						$html.= '<td>'.date('d-m-Y',strtotime($detalle['fecha_venc'])).'</td>'; 
						$html.= '<td>'.sprintf('%0.2f', $detalle['importe']).'</td>'; 
						$html.= '</tr>';
					}
					
				}
				$html.= '</tbody>';

				$html.= '</table>';
				$html.= '</td></tr>';

				//die($html);
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

				//echo $html;

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

			echo json_encode(array('result'=>'true','file_url'=>$data['id'].'.pdf'));
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

	    	if($digit1 != "1" && $digit1 != "5" && $digit1 != "7" && $digit1 != "9")
	        	$buffer .= $this->convertDigit($digit1) . "cien";
	        else{
	        		switch($digit1)
	        		{
	        			case "1":
	        				$buffer .= "cien";
	        				break;
	        			case "5":
	        				$buffer .= "quinien";
	        				break;
	        			case "7":
	        				$buffer .= "setecien";
	        				break;
	        			case "9":
	        				$buffer .= "novecien";
	        				break;
	        		}
	        	}
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
	            case "0":
	            	return "cero";
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
	    } else if($digit1 == "0"){
	    	switch ($digit2)
	        {
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
	                return "seis";
	            case "7":
	                return "siete";
	            case "8":
	                return "ocho";
	            case "9":
	                return "nueve";
	            case "0":
	                return "cero";
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
		{	$filename=$data['id']."_".date('d_m_Y_H_i_s').'_l.pdf';
			/*if(!is_dir(APPPATH.'reports/')){
				mkdir(APPPATH.'reports/');
			}*/
			if(!file_exists( './assets/reports/'.$filename)){
				$data['act'] = 'Print';
				$result = $this->getOperation($data);
				$id=$data['id'];
				$detalle_operacion=$this->db->query("select od.*,
				(select razon_social from banco where id = od.banco_id) as 'banco_nombre',
				(select razon_social from agente where id = od.emisor_id) as 'agente_razon_social',
				(select CONCAT(nombre,' ',apellido) from agente where id = od.emisor_id) as 'agente_nombre_apellido',
				c.tipo as tipo 
				from operacion_detalle as od INNER JOIN cheques as c ON od.cheque_id = c.id where od.operacion_id='".$id."';");
				
				if($detalle_operacion->num_rows()!=0){
					$data['detalle_operacion']= $detalle_operacion->result_array();					
				}

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


				// Obtine Listado de cheques
				$this->db->select('cheques.*');
				$this->db->from('cheques');
				$this->db->join('operacion_detalle', 'operacion_detalle.cheque_id = cheques.id');;
				$this->db->where(array('operacion_detalle.operacion_id' => $result['operation']['id'], 'cheques.tipo' => 2));
				$query_cheques = $this->db->get();

				//echo $this->db->last_query();				
				//die();

				$html_cheques_listado='';
				$html_cheques_listado_pie=array();

				if ( $query_cheques->num_rows() > 0 )
				{	
					//$html_cheques_listado_pie=($query_cheques->num_rows()==0)?'CON CHEQUE ':'CON CHEQUES ';
					$html_cheques_listado.= '<tr style="text-align: center"><th>Banco</th><th>Número</th><th>Importe</th><th>Fecha</th></tr>';	
					foreach($query_cheques->result() as $che)
					{
						$html_cheques_listado.= '<tr style="text-align: center">';
						$html_cheques_listado.= 	'<td>'.$this->getBankName($che->bancoId).'</td>';
						$html_cheques_listado.= 	'<td>'.$che->numero.'</td>';
						$html_cheques_listado.= 	'<td>'.number_format($che->importe, 2, ',', '.').'</td>';
						$html_cheques_listado.= 	'<td>'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html_cheques_listado.= '</tr>';


						$html_cheques_listado_pie[]=" Banco ".$this->getBankName($che->bancoId)." Nº ".$che->numero."";
					}
					
				}
				
				//Obtiene Detalle Transferencias:
				
				$this->db->select('transferencias.*');
				$this->db->from('transferencias');
				$this->db->join('operacion_detalle_transferencia', 'operacion_detalle_transferencia.transferencia_id = transferencias.id');;
				$this->db->where(array('operacion_detalle_transferencia.operacion_id' => $result['operation']['id']));
				$query = $this->db->get();
				$html_transferencias_listado='';
				$html_transferencias_listado_pie=array();
				if ($query->num_rows() != 0)
				{
					$html_transferencias_listado.= '<tr style="text-align: center"><th>Banco</th><th>CBU/Alias</th><th>Importe</th><th>Fecha</th></tr>';	
					foreach($query->result() as $che)
					{
						$html_transferencias_listado.= '<tr style="text-align: center">';
						$html_transferencias_listado.= 	'<td>'.$this->getBankName($che->banco_id).'</td>';
						if($che->cbu_nro!='' && $che->cbu_nro!=0){
							$html_transferencias_listado.= 	'<td style="text-align: center"> '.($che->cbu_nro).' </td>';
						}else{
							$html_transferencias_listado.= 	'<td style="text-align: center"> '.($che->cbu_alias).' </td>';
						}
						$html_transferencias_listado.= 	'<td>'.number_format($che->importe, 2, ',', '.').'</td>';
						$html_transferencias_listado.= 	'<td>'.date("d-m-Y", strtotime($che->fecha)).'</td>';
						$html_transferencias_listado.= '</tr>';

						$cbu_data=($che->cbu_nro!='' && $che->cbu_nro!=0)?$che->cbu_nro:$che->cbu_alias;
						$html_transferencias_listado_pie[]= "Banco ".$this->getBankName($che->banco_id)." al CBU ".$cbu_data."";
					}
					
				}
				//Detalle
				
				$html= '<table width="100%" style="font-family:Arial; font-size: 13pt;">';
				//Titulo
				$html.= '<tr><td style="text-align: right"><strong>'.$data['inversor']['razon_social'].'</td></tr>';
				//Header
				$html.= '<tr><td style="text-align:left;"><strong>LIQUIDACIÓN DE VALORES</strong></td></tr>';
				$html.= '<tr><td style="text-align:right;"><strong>FECHA: '.date("d-m-Y", strtotime($result['operation']['created'])).'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">CLIENTE: <strong>'. ($data['tenedor']['razon_social'] == '' ? $data['tenedor']['nombre'].' '.$data['tenedor']['apellido'] : $data['tenedor']['razon_social']).'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">DOMICILIO: <strong>'.$data['tenedor']['domicilio'].'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">CUIT: <strong>'.$data['tenedor']['cuit'].'</strong></td></tr>';
				$html.= '<tr><td style="text-align:left;">FACTURA TIPO: <strong style="padding-right: 10px">'.$result['operation']['factura_tipo'].'</strong> FACTURA Nro: <strong>'.$result['operation']['factura_nro'].'</strong></td></tr>';
				$html.= '<tr><td style="text-align:center; text-decoration: underline;">DETALLE DE VALORES COMPRADOS</td></tr>';
				//Cheque recibido
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000;">';
				$html.= '<thead>';
				$html.= '<tr style="text-align: center; font-size:16px;"><th>BANCO</th><th>NUMERO</th><th>LIBRADOR</th><th>F.PAGO</th><th>TASA</th><th>DIAS</th><th>IMPORTE $</th></tr>';
				$html.= '</thead>';
				
				$html.= '<tbody>';

				foreach($data['detalle_operacion'] as $detalle){
					
					if($detalle['tipo']==1){
						$html.='<tr style="text-align: center; font-size:15px; padding:10px !important;">';
						$html.= '<td>'.$detalle['banco_nombre'].'</td>'; 
						$html.= '<td>'.$detalle['nro_cheque'].'</td>'; 
						$html.= '<td>'.(($detalle['agente_razon_social']!='')?$detalle['agente_razon_social']:$detalle['agente_nombre_apellido']).'</td>'; 
						$html.= '<td>'.date('d-m-Y',strtotime($detalle['fecha_venc'])).'</td>'; 
						$html.= '<td>'.$detalle['tasa_mensual'].'</td>'; 
						$html.= '<td>'.$detalle['nro_dias'].'</td>'; 
						$html.= '<td>'.sprintf('%0.2f', $detalle['importe']).'</td>'; 
						$html.= '</tr>';
					}				
					
				}
				$html.= '</tbody>'; 

				$html.= '</table>';
				$html.= '</td></tr>';
				
				
				//Detalle
				$html.= '<tr><td><br>';
				$html.= '<table width="100%" style="border: 1px solid #000; margin-top:10px; ">';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">TOTAL DE VALORES $</td><td style="text-align:right">'.number_format($result['operation']['importe'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">INTERESES $</td><td style="text-align:right">'.number_format($result['operation']['interes'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">IMP DEB Y CRED BANCARIOS $</td><td style="text-align:right">'.number_format($result['operation']['impuesto_cheque'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">VALORES OTRA PLAZA $</td><td style="text-align:right">'.number_format($result['operation']['gastos'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">COMISIONES $</td><td style="text-align:right">'.number_format($result['operation']['comision_total'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">IVA $</td><td style="text-align:right">'.number_format($result['operation']['iva'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">SELLADO $</td><td style="text-align:right">'.number_format($result['operation']['sellado'], 2, ',', '.').'</td></tr>';
				$html.= '<tr><td style="width:25%"></td><td style="text-align:left;font-size:15px;">NETO A LIQUIDAR $</td><td style="text-align:right">'.number_format($result['operation']['neto'], 2, ',', '.').'</td></tr>';
				$html.= '</table></tr></td>';
				//Foother
				$html.= '<tr><td style="text-indent: 40px; text-align:justify; ">';
				$html.= 'El Pago de IVA y sellado, es abonado al momento de liquidación de la operación.-</td></tr> ';
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;  ">';
				$html.= '<p style="padding-top:10px; padding-bottom:10px;" >RECIBI IMPORTE NETO LIQUIDADO CON <?p><br> ';
				//Cheques de pago 
				$html.= '<table width="100%" style="border: 1px solid #000; padding-bottom:10px;">';
				//Get Cheques 
				$html.= $html_cheques_listado;				
				
				//Get Transferencias
				$html.= $html_transferencias_listado;
				
				
				$html.= '</table></td></tr>';
				//-----------------------------------------------------
				//Listado de cheuqes emitidos 
				$html.= '</td></tr>';
				$html.= '<tr><td style="text-indent: 40px; text-align:justify;"><br><strong>';
				//$html.= 'ESTA OPERACION SE CANCELA CON CHEQUE '.$data['banco']['razon_social'].' N° '.$result['operation']['nro_cheque'].'</td></tr>';
				$html.= 'ESTA OPERACION SE CANCELA  ';


				if(!empty($html_cheques_listado_pie)){
					$html.= "CON CHEQUE/S ".implode(',',$html_cheques_listado_pie);
				}
				if(!empty($html_cheques_listado_pie) &&  !empty($html_transferencias_listado_pie)){
					$html.=" y ";
				}
				if(!empty($html_transferencias_listado_pie)){

					$html.= "CON TRANFERENCIAS/S ".implode(',',$html_transferencias_listado_pie);
				}

				$html.= '</td></tr>';
				//Firmas
				$html.= '<tr><td style="padding-top:60px;"></td></tr>';
				/*
				$html.= '<table width="100%">';
				$html.= '<tr><td style="width: 50%; text-align:center;">'.$data['inversor']['razon_social'].'</td><td style="width: 50%; text-align:center;">'.($data['tenedor']['razon_social'] == '' ? $data['tenedor']['nombre'].' '.$data['tenedor']['apellido'] : $data['tenedor']['razon_social']).'</td></tr>';
				*/
				$html.= '</table>';
				
				$html.= '<table width="100%; position:absolute; bottom:05%; ">';
				$html.= '<tr>';
				$html.= ' <td style="width: 30%; text-align:center; border-top:1px solid #333; ">'.$data['inversor']['razon_social'].'</td>';
				$html.= ' <td style="width: 30%; text-align:center; border-top:0px;"></td>';
				$html.= '<td style="width: 30%; text-align:center; border-top:1px solid #333;  ">'.($data['tenedor']['razon_social'] == '' ? $data['tenedor']['nombre'].' '.$data['tenedor']['apellido'] : $data['tenedor']['razon_social']).'</td>';
				$html.= '</tr>';
				
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
				file_put_contents('./assets/reports/'.$filename, $output);
			}
			return $filename;
		}
	}
	

	public function setFactura($data){
		
		if(!isset($data['id'])){
			return false;
		}

		$result=$this->db->update(
			'operacion',array('factura_tipo'=>$data['tipo'],'factura_nro'=>$data['nro']),array('id'=>$data['id'])
		);

		/*$result=$this->db->update(
			'operacion',array('factura_tipo'=>$data['tipo'],'factura_nro'=>$data['nro']),array('id'=>$data['id'])
		);*/

		if($result){
			return true;
		}else{
			return false;
		}
		
	}

	

	public function addlog($operacion_id=0,$comment='',$status=0){

		if(isset($this->session->userdata['user_data'][0]['usrId'])){
			$data=array(
				'user_id'=>$this->session->userdata['user_data'][0]['usrId'],
				'operacion_id'=>$operacion_id,
				'comment'=>$comment,
				'status'=>1,
				'date_added'=>date('Y-m-d H:i:s'),
				
			);			
			return $this->db->insert('operacion_log',$data);
		}
		
	}
}
	
    