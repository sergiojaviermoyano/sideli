<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class welcome extends CI_Controller {

	function __construct()
        {
		parent::__construct();		
	}
    function index(){
        $this->load->view('welcome');
    }

    function importar(){
        $DB1 = $this->load->database('default', TRUE);
        $DB2 = $this->load->database('sideli_live', TRUE);
        
        $agentes1=$DB1->get('agente');
        var_dump($agentes1->num_rows());
        $agentes2=$DB2->get('agente');
        var_dump($agentes1->num_rows());

        /*$tables = $DB1->list_tables();
        
        foreach($tables as $key=>$item){
            var_dump($item);
        }


        die();
        $DB1->empty_table('cheques'); // Produces: DELETE FROM mytable
        $DB1->empty_table('agente'); // Produces: DELETE FROM mytable
        $DB1->empty_table('banco'); // Produces: DELETE FROM mytable
        */
        $DB1->empty_table('operacion'); // Produces: DELETE FROM mytable
        $DB1->empty_table('operacion_detalle'); // Produces: DELETE FROM mytable
        

        /*$query=$DB2->get('banco');
        foreach($query->result_array() as $key=>$item){
            var_dump($item);
            $DB1->insert('banco',$item);
        }
        die();*/
        /*foreach($agentes2->result_array() as $key=>$item){
            var_dump($item);
            $DB1->insert('agente',$item);
        }*/
        /*$cheques=$DB2->get('cheques');
        foreach($cheques->result_array() as $key=>$item){
            //var_dump($item);
            $DB1->insert('cheques',$item);
        }*/
        //die();
        $cheques=$DB2->get('operacion');
        foreach($cheques->result_array() as $key=>$item){
            
           
            
            $query_cheque =$DB1->get_where('cheques',array('numero'=>$item['nro_cheque']));
            $cheque_temp=$query_cheque->row_array();	

            $data=array(
                'operacion_id'=>$item['id'],
                'cheque_id'=>$cheque_temp['id'],
                'emisor_id'=>$item['agente_emisor_id'],
                'banco_id'=>$item['banco_id'],
                'nro_cheque'=>$item['nro_cheque'],
                'importe'=>$item['importe'],
                'fecha_venc'=>$item['fecha_venc'],
                'nro_dias'=>$item['nro_dias'],
                'tasa_mensual'=>$item['tasa_mensual'],
                'interes'=>$item['interes'],
                'impuesto_cheque'=>$item['impuesto_cheque'],
                'gastos'=>$item['gastos'],
                'compra'=>$item['compra'],
                'comision_valor'=>$item['comision_valor'],
                'comision_total'=>$item['comision_total'],
                'subtotal'=>$item['subtotal'],
                'iva'=>$item['iva'],
                'sellado'=>$item['sellado'],
                'neto'=>$item['neto']
            );


            $DB1->insert('operacion',$item);
            $DB1->insert('operacion_detalle',$data);

            $old_operacion_detalle=$DB2->query('select * from cheques as c inner join operacion_detalle as od ON c.id=od.cheque_id where od.operacion_id='.$item['id'].' and tipo=2;');
            if($old_operacion_detalle->num_rows()!=0){

                foreach($old_operacion_detalle->result_array() as $index=>$cheque){
                    print_r($cheque);

                    $cheque_salida=array(
                        'operacion_id'=>$item['id'],
                        'cheque_id'=>$cheque['id'],
                        'emisor_id'=>0,
                        'banco_id'=>$cheque['bancoId'],
                        'nro_cheque'=>$cheque['numero'],
                        'importe'=>$cheque['importe'],
                        'fecha_venc'=>$cheque['fecha'],
                        'nro_dias'=>1,
                    );

                    //print_r($cheque_salida);
                    $DB1->insert('operacion_detalle',$cheque_salida);
                }
            }

        }
    }

}
