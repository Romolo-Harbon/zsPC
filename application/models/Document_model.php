<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model{
    /*
     * 信息查询
     */
    public function File_SelType()
    {
        $data = $this->db->query("SELECT id,TypNam FROM `type_file` WHERE TypSta = 0")->result_array();
        return $data;
    }
    
    /*
     * 功能实现
     */
    //新增文档
    public function File_AddNew()
    {
        
    }
}