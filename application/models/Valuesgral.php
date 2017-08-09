<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Valuesgral extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Value_List(){

		$query= $this->db->get('valores');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}
	
	function getValue($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$id = $data['id'];

			$data = array();

			$query= $this->db->get_where('valores',array('id'=>$id));
			if ($query->num_rows() != 0)
			{
				$f = $query->result_array();
				$data['values'] = $f[0];
			} else {
				$values = array();
				$values['tasa'] = '';
				$values['impuestos'] = '';
				$values['gastos'] = '';
				$values['comision'] = '';
				$data['values'] = $values;
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
	
	function setValue($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$act = $data['act'];
			$impu = $data['impu'];
			$tasa = $data['tasa'];
			$gast = $data['gast'];
			$comi = $data['comi'];

			$data = array(
					   'tasa'		=> $tasa,
					   'impuestos'	=> $impu,
					   'gastos'		=> $gast,
					   'comision'	=> $comi
					);

			switch($act){

				case 'Edit':
					if($this->db->update('valores', $data, array('id'=>$id)) == false) {
						return false;
					}
					break;
			}


			return true;

		}
	}
}
?>