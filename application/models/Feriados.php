<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Feriados extends CI_Model
{
	function __construct()
	{
        parent::__construct();
        $this->load->dbforge();
        if(!$this->db->table_exists('feriados')){
            $this->createTable();
            $this->setMenu();                        
        }/*else{
            echo "Existe Tabla";
        }*/
              
    }
    function createTable(){
        $this->dbforge->add_field("`id` INT(11) NOT NULL AUTO_INCREMENT,
        `descripcion` VARCHAR(200) NULL DEFAULT '0',
        `fecha` DATE NULL DEFAULT NULL,
        `fijo` TINYINT(1) NULL DEFAULT '0',
        PRIMARY KEY (`id`)");
        $attributes = array('ENGINE' => 'InnoDB','COLLATE'=>'utf8_general_ci');
        $result=$this->dbforge->create_table('feriados', TRUE);
        
        return $result;
    }

    function setMenu(){

        $result=$this->db->get_where('sismenu',array('menuName'=>'Feriados','menuIcon'=>'fa fa fa-calendar','menuController'=>'feriado',));
        if($result->num_rows()!=0){
            // echo $this->db->last_query();
            //var_dump($result);
            return false;
        }
       
        $data=array(
            'menuName'=>'Feriados',
            'menuIcon'=>'fa fa fa-calendar',
            'menuController'=>'feriado',
            'menuView'=>'index',
            'menuFather'=>'12',
        );

        if($result=$this->db->insert('sismenu',$data)){
            $actions_query="insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Feriados'),(select actId from sisactions where actDescription = 'Add'));";
            $this->db->query($actions_query);
            //echo $this->db->last_query();
            $actions_query="insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Feriados'),(select actId from sisactions where actDescription = 'Edit'));";
            $this->db->query($actions_query);
            //echo $this->db->last_query();
            $actions_query="insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Feriados'),(select actId from sisactions where actDescription = 'Del'));";
            $this->db->query($actions_query);
            //echo $this->db->last_query();
            $actions_query="insert into sismenuactions values (null, (Select menuId from sismenu where menuName = 'Feriados'),(select actId from sisactions where actDescription = 'View'));";
            $this->db->query($actions_query);
            echo $this->db->last_query();
        }
        return true;
       
    }

    public function ListAll(){
        $this->db->order_by('fecha', 'ASC');
        $query= $this->db->get('feriados');
        if ($query->num_rows()!=0)
		{
            $result=$query->result_array();
            return $result;
            
        }else{
            return array();
        }
    }

    public function getByYear($year){
        $this->db->order_by('fecha', 'ASC');
        $query= $this->db->get_where('feriados',array('YEAR(fecha)'=>$year));
        if ($query->num_rows()!=0)
        {   $result=$query->result_array();
            $dates=array();
            foreach($result as $key => $item){
                $dates[]=$item['fecha'];
            }
            return json_encode($dates,true);
            
        }else{
            return array();
        }
    }

    public function add($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
            $params=array(
                'descripcion'=>$data['descripcion'],
                'fecha'=>date('Y-m-d',strtotime($data['fecha'])),
                'fijo' =>1,
            );

            if(isset($data['id']) && $data['id']!=''){
                $this->db->set($params);                
                $this->db->where('id', $data['id']);
                $this->db->update('feriados');
                return true;
            }else{                
                if($this->db->insert('feriados',$params)){
                    return $this->db->insert_id();
                }else{
                    return false;
                }
            }
            
        }
    }
}