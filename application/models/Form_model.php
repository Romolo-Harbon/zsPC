<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Form_model extends CI_Model{
		
	public function change_sta($id,$data)
		{
			$this->db->update('table_mes',$data,array('id'=>$id));
		}
	
	public function check(){
		$data=$this->db->get('table_mes')->result_array();
		return $data;
	}
	
	
}
?>