<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MesContro_model extends CI_Model{
    
    //更改状态【0草稿,1提交,2签批,3驳回,4逾期,5归集,6撤回归集,7重新提交,8删除】
    public function change_sta($FormN,$MesId,$CT)
    {
        
        $ids = implode(',', $MesId);
        $sql = "UPDATE ".$FormN." SET TabSta = CASE id ";
        foreach ($MesId as $id) {
            $sql .= sprintf("WHEN %d THEN %d ", $id, $CT); // 拼接SQL语句
        }
        $sql .= "END WHERE id IN (".$ids.")";
        $this->db->query($sql);
    }
    
}