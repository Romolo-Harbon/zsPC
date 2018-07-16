<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
	{
    		
    	public function checkAccount($UseNam)
    	{        	
        	$data = $this->db->get_where('user',array('UseNam'=>$UseNam))->result_array();
			return $data;
		}
		
		public function register($data)
		{
			$this->db->insert('user',$data);		
		}
		
		public function rset($UsePho,$data)
		{
			$this->db->update('user',$data,array('UsePho'=>$UsePho));
		}
		
		public function checkphone($UsePho)
    	{        	
        	$data = $this->db->get_where('user',array('UsePho'=>$UsePho))->result_array();
			return $data;
		}
    }
    
