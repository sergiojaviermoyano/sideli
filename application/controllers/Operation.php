<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class operation extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Operations');
		$this->load->model('Feriados');
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
		$data['feriados']=$this->Feriados->getByYear(date('Y'));
		if($data['data']['act'] == 'View'){
			$response['html'] = $this->load->view('operations/_consult', $data, true);
		} else {
			$data['js_to_load']="_view.js";	
			$response['html'] = $this->load->view('operations/_view', $data, true);
		}
		echo json_encode($response);
	}


	public function addOperation(){
		
		if($result=$this->Operations->add($this->input->post())){
			echo json_encode($this->load->view('operations/list', array('result'=>true), true));
		}else{
			echo json_encode($this->load->view('operations/list', array(), true));
		}
		

	}

	public function setFactura(){
		
		if($result=$this->Operations->setFactura($this->input->post())){
			echo json_encode($this->load->view('operations/list', array('result'=>true), true));
		}else{
			echo json_encode($this->load->view('operations/list', array(), true));
		}
		

	}

	public function printOperation(){
		echo json_encode($this->Operations->printOperation($this->input->post()));
	}

	public function printLiquidacion(){
		echo json_encode($this->Operations->printLiquidacion($this->input->post()));
	}
	
}
