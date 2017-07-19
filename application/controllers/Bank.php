<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bank extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Users');
	}

	public function index($permission)
	{
		$data['list'] = $this->Users->User_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('bank/list', $data, true));
	}
}
