<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Checks extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Check_List(){

		$this->db->select("ch.*, bo.razon_social as rsbco, bo.sucursal, ag.nombre, ag.apellido, ag.razon_social as rsag");
		$this->db->from('cheques ch');
		$this->db->join('banco bo','bo.id=ch.bancoId');
		$this->db->join('agente ag','ag.id=ch.agenteId');
		$query = $this->db->get();
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}

	function getTotalCheques($data=null){

		$this->db->order_by('created', 'desc');
		if($data['search']['value']!=''){
            $this->db->group_start();
			$this->db->like('numero', $data['search']['value']);
			$this->db->or_like('importe', $data['search']['value']);
			$this->db->or_like('bo.razon_social', $data['search']['value']);
			$this->db->or_like('ag.nombre', $data['search']['value']);
			$this->db->or_like('ag.apellido', $data['search']['value']);
			$this->db->or_like('ag.razon_social', $data['search']['value']); //DATE_FORMAT(date,'%d/%m/%Y')
			//$this->db->or_like('DATE_FORMAT(vencimiento, "%d-%m-%Y")', $data['search']['value']);
			$this->db->limit($data['length'],$data['start']);
            $this->db->group_end();
		}
        
		$this->db->select("ch.*, bo.razon_social as rsbco, bo.sucursal, ag.nombre, ag.apellido, ag.razon_social as rsag");
		$this->db->from('cheques ch');
		$this->db->join('banco bo','bo.id=ch.bancoId');
		$this->db->join('agente ag','ag.id=ch.agenteId');
		$query= $this->db->get();
        
		return $query->num_rows();
		
	}

	function Cheques_List_datatable($data=null, $type=false){


		$this->db->order_by('created', 'desc');
		$this->db->limit($data['length'],$data['start']);
		if($data['search']['value']!=''){
			$this->db->group_start();
			$this->db->like('numero', $data['search']['value']);
			$this->db->or_like('importe', $data['search']['value']);
			$this->db->or_like('bo.razon_social', $data['search']['value']);
			$this->db->or_like('ag.nombre', $data['search']['value']);
			$this->db->or_like('ag.apellido', $data['search']['value']);
			$this->db->or_like('ag.razon_social', $data['search']['value']);
			//$this->db->or_like('DATE_FORMAT(vencimiento, "%d-%m-%Y")', $data['search']['value']);
			$this->db->limit($data['length'],$data['start']);
            $this->db->group_end();
		}
		$this->db->select("ch.*, bo.razon_social as rsbco, bo.sucursal, ag.nombre, ag.apellido, ag.razon_social as rsag");
		$this->db->from('cheques ch');
		$this->db->join('banco bo','bo.id=ch.bancoId');
		$this->db->join('agente ag','ag.id=ch.agenteId');
		$query= $this->db->get();
        
		if ($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
		{
			return array();
		}
	}
	
	function getCheck($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('cheques',array('id'=>$id));
			if ($query->num_rows() != 0)
			{
				$f = $query->result_array();
				$f[0]['fecha'] = explode('-',$f[0]['fecha']);
				$f[0]['fecha'] = $f[0]['fecha'][2].'-'.$f[0]['fecha'][1].'-'.$f[0]['fecha'][0];
				$f[0]['vencimiento'] = explode('-',$f[0]['vencimiento']);
				$f[0]['vencimiento'] = $f[0]['vencimiento'][2].'-'.$f[0]['vencimiento'][1].'-'.$f[0]['vencimiento'][0];
				//String descripcion del banco
				$this->load->model('Banks');
				$result = $this->Banks->getBank(array('id' => $f[0]['bancoId'], 'act' => 'add'));
				$f[0]['banco'] = $result['bank']['razon_social'].'  Suc:'.$result['bank']['sucursal'];
				//String descripcion del emisor
				$this->load->model('Agents');
				$result = $this->Agents->getAgente(array('id' => $f[0]['agenteId'], 'act' => 'add'), 1);
				$f[0]['emisor'] = $result['agente']['apellido'].', '.$result['agente']['nombre'].($result['agente']['razon_social'] == '' ? '' : '('.$result['agente']['razon_social'].') ').' CUIT:'.$result['agente']['cuit'];
				$data['check'] = $f[0];
			} else {
				$check = array();
				$check['fecha'] = '';
				$check['bancoId'] = '';
				$check['agenteId'] = '';
				$check['importe'] = '';
				$check['vencimiento'] = '';
				$check['observacion'] = '';
				$check['numero'] = '';
				$check['banco'] = '';
				$check['emisor'] = '';
				$data['check'] = $check;
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
	
	function setCheck_($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id 			= $data['id'];
			$act 			= $data['act'];
            $bancoId 		= $data['bancoId'];
            $fecha			= explode('-',$data['fecha']);
            $fecha 			= $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
            $numero			= $data['numero'];
            $vencimiento	= explode('-',$data['vencimiento']);
            $vencimiento 	= $vencimiento[2].'-'.$vencimiento[1].'-'.$vencimiento[0];
            $importe		= $data['importe'];
            $agenteId		= $data['agenteId'];
            $observacion	= $data['observacion'];

			$data = array(
					   'fecha'		=> $fecha,
					   'bancoId'	=> $bancoId,
					   'agenteId'	=> $agenteId,
					   'importe'	=> $importe,
					   'vencimiento'=> $vencimiento,
					   'observacion'=> $observacion,
					   'numero'		=>$numero
					);

			switch($act){
				case 'Add':
					if($this->db->insert('cheques', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					if($this->db->update('cheques', $data, array('id'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					if($this->db->delete('cheques', array('id'=>$id)) == false) {
						return false;
					}
					
					break;
			}


			return true;

		}
	}

	function validate($data = null){
		if($data == null)
		{
			return 0;
		}
		else
		{
			$nro = $data['nro'];
			$id = $data['id'];

			$query= $this->db->get_where('cheques',array('bancoId'=>$id, 'numero'=>$nro));
			if ($query->num_rows() != 0)
			{
				return 0;
			} else {
				return 1;
			}
		}
	}
}
?>