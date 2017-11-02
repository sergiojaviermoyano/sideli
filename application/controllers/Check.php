<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class check extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Checks');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = array();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('checks/list', $data, true));
	}

	public function listingCheques(){		
		$totalCheques=$this->Checks->getTotalCheques($_REQUEST);
		$cheques = $this->Checks->Cheques_List_datatable($_REQUEST);

		$result=array(
			'draw'=>$_REQUEST['draw'],
			'recordsTotal'=>$totalCheques,
			'recordsFiltered'=>$totalCheques,
			'data'=>$cheques,
		);
		echo json_encode($result);
	}

	public function getCheck(){
		$data['data'] = $this->Checks->getCheck($this->input->post());
		$response['html'] = $this->load->view('checks/view_', $data, true);
		echo json_encode($response);
	}
	
	public function setCheck_(){
		$data = $this->Checks->setCheck_($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}

	public function validate(){
		echo json_encode($this->Checks->validate($this->input->post()));
	}
}
