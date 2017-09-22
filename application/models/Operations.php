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
		
		if($data['agente_emisor_id']=='0'){
			$agente_emisor= array(
				'nombre'=>$data['emisor_nombre'],
				'apellido'=>$data['emisor_apellido'],
				'cuit'=>$data['emisor_cuit'],
				'razon_social'=>$data['emisor_nombre']." ".$data['emisor_apellido'],
				'domicilio'=>'',
				'tipo'=>1,
				'estado'=>'ac',
			);
			//var_dump($agente_emisor);
			
			$this->db->trans_start();
			$this->db->set('created', 'NOW()', FALSE);
			$this->db->set('updated', 'NOW()', FALSE);
			$result= $this->db->insert('agente', $agente_emisor);
			$data['agente_emisor_id'] = $this->db->insert_id();
			$this->db->trans_complete();
		}
		
		if($data['agente_tomador_id']=='0'){
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
			$cheque_params=array();
			$operacion_id=1;
			foreach($data['cheque_salida'] as $key=>$item){
				$temp_cheque=array(
					'fecha'=>date('Y-m-d',strtotime($item['fecha'])),
					'bancoId'=>$item['banco_id'],
					'numero'=>$item['nro'],
					'importe'=>floatval($item['importe']),
					'estado'=>'AC',
					'observacion'=>null,
					'espropio'=>1,
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
    
}
	
    