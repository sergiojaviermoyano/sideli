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
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
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
	
    