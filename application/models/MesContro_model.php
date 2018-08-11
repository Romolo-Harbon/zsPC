<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MesContro_model extends CI_Model{
    /*
     * 信息状态管理
     */
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
    /*
     * 流程管理
     */
    //新建流转信息
    public function CirSave_New($MId,$MData)
    {
        $dataList = array('CirOne','CirTwo','CirThr','CirFor','CirFiv','CirSix','CirSen','CirEig','CirNin','CirTen',);
        $UseCId = $_SESSION['UserAId'];
        $UseCTm = date('Y-m-d H:i:s');
        list($t1, $t2) = explode(' ', microtime());
        $CirSmp = (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
        $i=1;
        //判断此类型有没有流程信息【判断是否重复新建】
        $queryChe = $this->db->query("select CirSmp from type_mes where id = '".$MId."'");
        $rowChe = $queryChe->row();
            //如果是重复新建
        if(isset($rowChe))
        {
            $CirSmpOld = $rowChe->CirSmp;
            //查询流程信息的详细信息
            $queryDetail = $this->db->query("select CirOne,CirTwo,CirThr,CirFor,CirFiv,CirSix,CirSen,CirEig,CirNin,CirTen from circle_default where CirSmp = '".$CirSmpOld."' ");
            $rowDetail = $queryDetail->row_array();
            //删除流程详情
            for($i=0;$i<count($rowDetail);$i++){
                $sqlDelDetail = "delete from circle_detailm where id = '".$rowDetail[$dataList[$i]]."' ";
                $this->db->query($sqlDelDetail);
            }
            //若有流程信息则将其删除
            $sqlDelMes = "delete from circle_default where CirSmp = '".$CirSmpOld."'";
            $this->db->query($sqlDelMes);
        }
        //创建流程信息【或重新新建】
        $this->db->query("insert into circle_default set CirSmp = ".$CirSmp.",CirCPe = '".$UseCId."',CirCTm = '".$UseCTm."' ");
        
        for($i=0;$i<count($MData);$i++)
        {
            //获取部门id
            $query = $this->db->query("select id from role where RolNam = '".$MData[$i]."' and RolSta = 0");
            $row = $query->row_array();
            //创建流程信息
            $sql = "insert into circle_detailm set DepIdS = '".$row['id']."',UseCId = '".$UseCId."',UseCTm = '".$UseCTm."' ";
            $this->db->query($sql);
            $NewMesId = $this->db->insert_id();
            //绑定流程信息与流程详情
            $sqlTie = "update circle_default set ".$dataList[$i]." = '".$NewMesId."', CirNum = '".($i+1)."' where CirSmp='".$CirSmp."' ";
            $this->db->query($sqlTie);
        }
        //绑定流程信息与类型
        $this->db->query("update type_mes set CirSmp='".$CirSmp."' where id = '".$MId."' ");
        $sqlSta = $this->db->affected_rows();
        //释放掉查询结果所占的内存，并删除结果的资源标识
        $query->free_result();
        $queryChe->free_result();
        return $sqlSta;
    }
    //显示流转信息
    public function CirMes_Show($id)
    {
        //定义数组
        $dataList = array('CirOne','CirTwo','CirThr','CirFor','CirFiv','CirSix','CirSen','CirEig','CirNin','CirTen',);
        //获取流转属性时间戳
        $queryChe = $this->db->query("select CirSmp from type_mes where id = '".$id."'");
        $rowChe = $queryChe->row();
//      p($rowChe) ;
        //获取流转属性
        $CirSmp = $rowChe->CirSmp;
        if($CirSmp)
        {
            //查询流程信息的详细信息
            $queryDetail = $this->db->query("select CirOne,CirTwo,CirThr,CirFor,CirFiv,CirSix,CirSen,CirEig,CirNin,CirTen,CirNum from circle_default where CirSmp = '".$CirSmp."'");
            $rowDetail = $queryDetail->row();
            $CirNum = $rowDetail->CirNum;
            //查找流程详情
            for($i=0;$i<$CirNum;$i++){
                if($rowDetail->$dataList[$i])
                {
                    $queryMes = $this->db->query("select RolNam from circle_detailm a,role b where a.DepIdS = b.id and a.id = '".$rowDetail->$dataList[$i]."' ");
                    $rowMus = $queryMes->row_array();
                    $data[] = $rowMus['RolNam'];
                }
            }
            return $data;
        }
        return $data = array('','','','');
    }
    //修改流转信息
    public function CirSave_Change()
    {
        
    }
    
}