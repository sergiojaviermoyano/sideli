<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class investor extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Investors');
		//$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		//var_dump($permission);
		$data['list'] = $this->Investors->List_all();
		$data['permission'] = $permission;
		
		echo json_encode($this->load->view('investors/list', $data, true));
	}

	public function getInvestor(){
		$data['data'] = $this->Investors->getInvestor($this->input->post());
		
		$response['html'] = $this->load->view('investors/_view', $data, true);
		echo json_encode($response);
	}

	public function setInvestor(){
		
		$data = $this->Investors->setInvestor($this->input->post());
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
