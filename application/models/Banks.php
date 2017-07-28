<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Banks extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Bank_List(){

		$query= $this->db->get('banco');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getBank($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('banco',array('id'=>$id));
			if ($query->num_rows() != 0)
			{
				$f = $query->result_array();
				$data['bank'] = $f[0];
			} else {
				$bank = array();
				$bank['razon_social'] = '';
				$bank['sucursal'] = '';
				$bank['estado'] = '';
				$data['bank'] = $bank;
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
	
	function setBank($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$name = $data['name'];
			$sucu = $data['sucu'];
			$esta = $data['esta'];

			$data = array(
					   'razon_social'	=> $name,
					   'sucursal'		=> $sucu,
					   'estado'			=> $esta
					);

			switch($act){
				case 'Add':
					if($this->db->insert('banco', $data) == false) {
						return false;
					}
					break;

				case 'Edit':
					if($this->db->update('banco', $data, array('id'=>$id)) == false) {
						return false;
					}
					break;

				case 'Del':
					if($this->db->delete('banco', array('id'=>$id)) == false) {
						return false;
					}
					
					break;
			}


			return true;

		}
	}

	function search($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$banks = array();

		$this->db->select('*');
		$this->db->from('banco');
		$this->db->where(array('estado'=>'AC'));
		if($str != ''){
			$this->db->like('razon_social', $str);
			$this->db->or_like('sucursal', $str);
		}
		$this->db->order_by('razon_social asc', 'sucursal asc');
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			$banks = $query->result_array();
		}

		return $banks;
	}
}
?>