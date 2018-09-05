<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Investors extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function List_all($estado=false){
		
		if($estado){
			$this->db->where("estado",$estado);
		}
		$query= $this->db->get('inversor');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return array();
		}
	}

	function getInvestor($data){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('inversor',array('id'=>$id));
			if ($query->num_rows() != 0)
			{	
				
				$temp=$query->result_array();
				
				$data['inversor'] = $temp[0];
			} else {
				$temp = array();
				$temp['id'] = null;
				$temp['razon_social'] = '';
				$temp['cuit'] = '';
				$temp['domicilio'] = '';
				$temp['factura_nro'] = 0;				
				$temp['estado'] = 0;
				$data['inversor'] = $temp;
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
				'factura_nro'=>$data['factura_nro'],
				'estado'=>$data['estado'],
			);
			
			switch($action){
				case 'Add':{
					$this->db->trans_start();
					$result= $this->db->insert('inversor', $data_temp);
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

	public function getNextFacturaNro($id){

		$query=$this->db->query('select (factura_nro+1) next_factura_id from inversor where id='.$id.' order by factura_nro desc ;');
		if ($query->num_rows() != 0){			
			return $query->row_array();
		}else{
			$query=$this->db->query('select (max(factura_nro)+1) as next_factura_id from inversor where inversor_id='.$id.' order by factura_nro desc ;');
			return $query->row_array();
		}
		
	}
    
}
	
    