<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Affair_model extends CI_Model{
    //信息查询[待办、重要或者紧急]
    public function affairShow_table($type)
    {
        $sql01 = "select id,TabNam as name from table_mes where TabSta=1";
        $sql02 = "select id,FleNam as name from file_mes where FleSta=1";
        switch ( $type ) {
            case 1:
                $sql01 .= " and ImpSta = 1";
                $sql02 .= " and ImpSta = 1";
                break;
            case 2:
                $sql01 .= " and CasSta = 1";
                $sql02 .= " and CasSta = 1";
                break;
            default:break;
        }
        $data['aaData'] = $this->db->query($sql01)->result_array();
        $data['file'] = $this->db->query($sql02)->result_array();
        return $data;
    }
    //信息查询[已经归档的文件]
    public function affairShow_packDoc(){
        $sql = "select id,FleNam as name from file_mes where FleSta=4 ";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }
    //获取被选中的对应信息
    public function MesSel()
    {
        
    }
    
}