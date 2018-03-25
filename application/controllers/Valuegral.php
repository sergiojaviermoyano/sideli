<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class valuegral extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Valuesgral');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Valuesgral->Value_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('valuesgral/list', $data, true));
	}

	public function getValue(){
		$data['data'] = $this->Valuesgral->getValue($this->input->post());
		$response['html'] = $this->load->view('valuesgral/view_', $data, true);
		echo json_encode($response);
	}

	public function getValueData(){
		$data['data'] = $this->Valuesgral->getValue($this->input->post());
		$response['html'] = $this->load->view('valuesgral/view_', $data, true);
		echo json_encode($response);
	}
	public function getConfigValue(){ 
        $data = $this->Valuesgral->Value_List();
       //var_dump($data);
		echo json_encode($data, true);
    }
	public function setValue(){
		$data = $this->Valuesgral->setValue($this->input->post());
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
