<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class feriado extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Feriados');
		//$this->Users->updateSession(true);
    }
    
    /*function setMenu(){
        $this->Operations->List_all();
    }*/

	public function index($permission)
	{ 
		$data['list'] = $this->Feriados->ListAll();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('feriados/index', $data, true));
    }

    public function addDay(){
        
        if($result=$this->Feriados->add($this->input->post())){
           
            echo json_encode(array('result'=>true));
        }else{
            echo json_encode(array('result'=>false));
        }
		
        
    }

    public function deleteDay(){
        
        if($result=$this->Feriados->delete($this->input->post())){
           
            echo json_encode(array('result'=>true));
        }else{
            echo json_encode(array('result'=>false));
        }
		
        
    }
}