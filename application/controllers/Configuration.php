<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class configuration extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Configurations');
		$this->load->model('Groups');
		$this->Users->updateSession(true);
	}

	public function getConfiguration(){
		$data['data'] = $this->Configurations->get_();
		echo json_encode($this->load->view('configuration/view_', $data, true));
		
	}

	public function seConfiguration(){
		$data = $this->Configurations->set_($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}

	public function menu(){
		
		$data['data'] =null;
		//echo json_encode($this->load->view('configuration/menu', $data, true));
		$this->load->view('header');
		$userdata = $this->session->userdata('user_data');
		$data['userName'] = $userdata[0]['usrNick'];
		$this->load->view('dash', $data);
		$menu['menu'] = $this->Groups->buildMenu();
		$this->load->view('menu',$menu);
		$this->load->view('configuration/menu');
		$this->load->view('footerdash');
		$this->load->view('footer');
	}

}
