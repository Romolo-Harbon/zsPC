<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class System_model extends CI_Model
{
    /*
     * 表单或文档类型
     */
    //新增类型
    public function TypeM_addNew($Type,$data)
    {
        $this->db->insert($Type,$data);
    }
    //信息显示
    public function TypeM_selectMes()
    {
        $data = $this->db->query("SELECT id,TypNam,TypCTm,TypCPe,TypEls FROM `type_file` WHERE TypSta = 0")->result_array();
//      p($data);
        return $data;
    }
}