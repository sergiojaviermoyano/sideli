<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class agent extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Agents');
	}

	public function index($permission)
	{
		$data['list'] = $this->Agents->Emisor_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('emisor/list', $data, true));
	}

	public function emisor_list($permission)
	{
		$data['list'] = $this->Agents->Emisor_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('agent/emisor_list', $data, true));
	}

	public function listingEmisores(){

		$totalEmisores=$this->Agents->getTotalEmisores($_REQUEST);
		$emisores = $this->Agents->Emisores_List_datatable($_REQUEST);

		$result=array(
			'draw'=>$_REQUEST['draw'],
			'recordsTotal'=>$totalEmisores,
			'recordsFiltered'=>$totalEmisores,
			'data'=>$emisores,
		);
		echo json_encode($result);
	}

	public function getEmisor(){

		$data['data'] = $this->Agents->getEmisor($this->input->post());
		$response['html'] = $this->load->view('agent/emisor_view_', $data, true);
		echo json_encode($response);

	}

	public function setEmisor(){
		$data = $this->Agents->setAgent($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}
}
