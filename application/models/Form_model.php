<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Form_model extends CI_Model{
    /*
     * 页面加载
     */
	//页面加载时的表格信息查询
	public function formDraf_Sel($CT)
    {
        $data=$this->db->query("SELECT id,TabNam,TabCTm FROM table_mes WHERE TabSta=".$CT."")->result_array();
        return $data;
    }
    //按模板列表查询
    public function TreeShowSelect($id,$typeSta)
    {
        $data = $this->db->query("SELECT id,TabNam,TabCTm FROM table_mes WHERE TMoIdS = ".$id." AND TabSta = ".$typeSta."")->result_array();
        return $data;
    }
    
	
	
}
