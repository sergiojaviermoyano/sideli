<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class agent extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Agents');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Agents->Agent_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('emisor/list', $data, true));
	}

	public function emisor_list($permission){
		//$data['list'] = array();//$this->Agents->Agent_List(1);
		$data['type'] = 1;
		$data['permission'] = $permission;
		echo json_encode($this->load->view('agent/emisor_list', $data, true));
	}
	public function tenedor_list($permission){
		//$data['list'] = $this->Agents->Agent_List(2);
		$data['type'] = 2;
		$data['permission'] = $permission;
		echo json_encode($this->load->view('agent/emisor_list', $data, true));
	}

	public function listingAgent($type=false){		
		$totalAgentes=$this->Agents->getTotalAgentes($_REQUEST);
		$agentes = $this->Agents->Agentes_List_datatable($_REQUEST,$type);

		$result=array(
			'draw'=>$_REQUEST['draw'],
			'recordsTotal'=>$totalAgentes,
			'recordsFiltered'=>$totalAgentes,
			'data'=>$agentes,
		);
		echo json_encode($result);
	}



	public function getAgente($type=false){
		
		$data['data'] = $this->Agents->getAgente($this->input->post(),$type);
		$response['html'] = $this->load->view('agent/emisor_view_', $data, true);
		echo json_encode($response);

	}

	public function setAgente(){
		$data = $this->Agents->setAgente($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}

	public function buscadorDeAgentes(){
		$data = $this->Agents->search($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}
}
