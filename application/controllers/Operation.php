<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class operation extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Operations');
		//$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		
		//var_dump($permission);
		$data['list'] = $this->Operations->List_all();
		$data['permission'] = $permission;
		
		echo json_encode($this->load->view('operations/list', $data, true));
	}

    public function getOperation(){
		$data['data'] = $this->Operations->getOperation($this->input->post());
		
		$response['html'] = $this->load->view('operations/_view', $data, true);
		echo json_encode($response);
	}


}