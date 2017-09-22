<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Agents extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Agent_List($type=false){
		if($type!=false){
			
			$this->db->where('tipo',$type);
		}

		$query= $this->db->get('agente');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}

	function getAgente($data = null,$type=1){
		if($data == null)
		{
			return false;
		}else{
			$action   = $data['act'];
			$idEmisor = $data['id'];
			$data     = array();
			$query    = $this->db->get_where('agente',array('id'=>$idEmisor,'tipo'=>$type));
			//echo $this->db->last_query();
			if($query->num_rows()>0){
				
				$result = $query->result_array();
				$result=$result[0];
				
			}else{
				$result = array(
					'id'=>null,
					'nombre'=>'',
					'apellido'=>'',
					'cuit'=>'',
					'razon_social'=>'',
					'domicilio'=>'',
					'telefono'=>'',
					'celular'=>'',
					'email'=>'',
					'tipo'=>$type,
					'estado'=>'ac',
				);
			}
			//var_dump($result);
			$data['agente']=$result;
		}

		$readonly = false;
		if($action == 'Del' || $action == 'View'){
			$readonly = true;
		}
		$data['read'] = $readonly;
		$data['act'] = $action;

		return $data;

	}

	function setAgente($data = null){
    	if($data == null){
			return false;
		}
		else{

			$action = 	$data['act'];
			$id = 		$data['id'];

			$data = array(
				'nombre'=>$data['nombre'],
				'apellido'=>$data['apellido'],
				'cuit'=>str_replace('-','',$data['cuit']),
				'razon_social'=>$data['razon_social'],
				'domicilio'=>$data['domicilio'],
				'telefono'=>$data['telefono'],
				'celular'=>$data['celular'],
				'email'=>$data['email'],
				'tipo'=>$data['tipo'],
				'estado'=>'ac',
			);
			switch($action){
				case 'Add':{
					$this->db->trans_start();
					$this->db->set('created', 'NOW()', FALSE);
					$this->db->set('updated', 'NOW()', FALSE);
					$result= $this->db->insert('agente', $data);
					$idOrder = $this->db->insert_id();
					$this->db->trans_complete();
					break;
				}
				case 'Edit':{
					if($this->db->update('agente', $data, array('id'=>$id)) == false) {
				 		return false;
				 	}
					break;
				}
				default:{	
					break;
				}
			}

		}

		return true;
	}
    
    function getTotalAgentes($data=null,$type=false){

		$this->db->order_by('created', 'desc');
		if($data['search']['value']!=''){
            $this->db->group_start();
			$this->db->like('nombre', $data['search']['value']);
			$this->db->or_like('apellido', $data['search']['value']);
			$this->db->or_like('cuit', $data['search']['value']);
			$this->db->or_like('domicilio', $data['search']['value']);
			$this->db->or_like('telefono', $data['search']['value']);
			$this->db->or_like('celular', $data['search']['value']);
			$this->db->or_like('email', $data['search']['value']);
			$this->db->limit($data['length'],$data['start']);
            $this->db->group_end();
		}
		if($type){
			$this->db->where('tipo',$type);
		}
        
		$query= $this->db->get('agente');
        //die($this->db->last_query());
		return $query->num_rows();
		
	}

	function Agentes_List_datatable($data=null, $type=false){


		$this->db->order_by('created', 'desc');
		$this->db->limit($data['length'],$data['start']);
		if($data['search']['value']!=''){
			$this->db->group_start();
			$this->db->like('nombre', $data['search']['value']);
			$this->db->or_like('apellido', $data['search']['value']);
			$this->db->or_like('cuit', $data['search']['value']);
			$this->db->or_like('domicilio', $data['search']['value']);
			$this->db->or_like('telefono', $data['search']['value']);
			$this->db->or_like('celular', $data['search']['value']);
			$this->db->or_like('email', $data['search']['value']);
			$this->db->limit($data['length'],$data['start']);
            $this->db->group_end();
		}
		if($type){
			$this->db->where('tipo',$type);
		}
		$query= $this->db->get('agente');
        //die($this->db->last_query());
		if ($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	function search($data = null){
		$str = '';
		$type = 0;
		if($data != null){
			$str = $data['code'];
			$type = $data['type'] == 'E' ? 1 : 2;
		}

		$agents = array();

		$this->db->select('id, nombre, apellido, razon_social, cuit,domicilio');
		$this->db->from('agente');
		$this->db->where(array('estado'=>'AC', 'tipo' => $type));
		if($str != ''){
			$this->db->like('razon_social', $str);
			$this->db->or_like('nombre', $str);
			$this->db->or_like('apellido', $str);
			$this->db->or_like('cuit', $str);
		}
		$this->db->order_by('apellido asc', 'nombre asc');
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			$agents = $query->result_array();
		}

		return $agents;
	}
}
?>