<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class System_model extends CI_Model
{
    /*
     * 表单或文档类型
     */
    //信息显示
    public function TypeM_selectMes($type)
    {
        $data = $this->db->query("SELECT id,TypNam,TypCTm,TypCPe,TypEls FROM ".$type." WHERE TypSta = 0")->result_array();
        return $data;
    }
    //新增类型
    public function TypeM_addNew($Type,$data)
    {
        $this->db->insert($Type,$data);
    }
    //删除数据
    public function TypeDel($id,$type)
    {
        $this->db->delete($type,array('id'=>$id));
    }
    //修改类型
    public function TypeM_Edit($Type,$data,$id)
    {
        $this->db->update($Type,$data,array('id'=>$id));
    }
    /*
     * 模板节点
     */
    //显示
    public function TreeShow()
    {
        $data = $this->db->query('SELECT id,ParIdS,NodNam as text FROM noidSet WHERE NodSta=0')->result_array();
        return $data;
    }
    //保存新建
    public function TreeEditSaveN ($data)
    {
        $this->db->insert('noidset',$data);
    }
    //保存删除
    public function TreeEditSaveD ($data,$dataPId)
    {
        $this->db->delete('noidset',$data);
        $this->db->delete('noidset',$dataPId);
//      $this->db->update('noidset',array('NodSta'=>9),$data);
    }
    /*
     * 部门及人员设置
     */
    //信息显示
    public function RoleM_selectMes()
    {
        $data = $this->db->query("SELECT id,RolNam,RolCTm,RolCPe,RolEls FROM role WHERE RolSta = 0")->result_array();
        return $data;
    }
    //新增类型
    public function RoleM_addNew($data)
    {
        $this->db->insert('role',$data);
    }
    //删除数据
    public function RoleDel($id)
    {
        $this->db->delete('role',array('id'=>$id));
    }
    //修改类型
    public function RoleM_Edit($data,$id)
    {
        $this->db->update('role',$data,array('id'=>$id));
    }
    //部门人员信息查询【无分配】
    public function SelPeoMes()
    {
        $data = $this->db->query('SELECT id,UseAcc,UsePeo FROM `user` WHERE RolSta = 0 and UseSta=1')->result_array();
        return $data;
    }
    //部门人员信息查询【已经分配】
    public function SelPeoMesED($id)
    {
        $data = $this->db->query('SELECT c.id,c.UseAcc,c.UsePeo FROM `role` a,link_userol b,`user` c WHERE b.RolIdS = '.$id.' and b.UseIdS = c.id and b.DatSta = 0')->result_array();
        return $data;
    }
    //保存部门设置
    public function RoleLinUse_Set($RoleId,$UsePeo,$UseAcc)
    {
        //查询id
        $sql = "SELECT id FROM `user` WHERE UseAcc='".$UseAcc."' and UsePeo='".$UsePeo."'";
        $UseId = $this->db->query($sql)->result_array();
        //更新用户表
        $sqlUpdate = "UPDATE user set RolSta=1 where id=".$UseId[0]['id']."";
        $this->db->query($sqlUpdate);
        //更新关联表
        $sqlInsert = "insert into link_userol (UseIdS,RolIdS,DatSta) VALUES(".$UseId[0]['id'].",".$RoleId.",0)";
        $this->db->query($sqlInsert);
    }
    
    
}