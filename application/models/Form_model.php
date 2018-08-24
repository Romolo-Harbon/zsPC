<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Form_model extends CI_Model{
    /*
     * 页面加载
     */
    //按状态查询表单列表
    public function FormSta($FormType)
    {
        switch($FormType)
        {
            case 'sign':
                $formSta = 1;
                break;
            case 'rejt':
                $formSta = 2;
                break;
            case 'over':
                $formSta = 3;
                break;
            default:break;
        }
        $sql = "SELECT IntIdA as formId,TabMId as nodeId,ProAId as projectId,TabNam as formName,TabUDa as uploadTime,TabCTm as createTime,imgurl,page,CirSmp,ImpSta,CasSta,TabEls,TabTyp,TabDTm,TabSta,TabMNa FROM table_mes WHERE TabSta = '".$formSta."' ";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }
    
    //按模板列表查询
//  public function TreeShowSelect($id,$typeSta,$PId)
    public function TreeShowSelect($id,$typeSta)
    {
//      $sql = "SELECT IntIdA as formId,TabMId as nodeId,ProAId as projectId,TabNam as formName,TabUDa as uploadTime,TabCTm as createTime,imgurl,page,CirSmp,ImpSta,CasSta,TabEls,TabTyp,TabDTm FROM table_mes WHERE TabMId = '".$id."' AND ProAId = '".$PId."' AND TabSta = '".$typeSta."' ";
        $sql = "SELECT IntIdA as formId,TabMId as nodeId,ProAId as projectId,TabNam as formName,TabUDa as uploadTime,TabCTm as createTime,imgurl,page,CirSmp,ImpSta,CasSta,TabEls,TabTyp,TabDTm,TabSta,TabMNa FROM table_mes WHERE TabMId = '".$id."'  AND TabSta = '".$typeSta."' ";
        $data = $this->db->query($sql)->result_array();
        return $data;
//      echo $sql;
    }
    
    
    
	//表单信息获取
	public function FormMesLoad($FormId,$FormType)
	{
	    switch($FormType)
	    {
	        case 'draf':
	            $formSta = 0;
	            break;
	        case 'sign':
	            $formSta = 1;
                break;
            case 'rejt':
                $formSta = 2;
                break;
            case 'over':
                $formSta = 3;
                break;
            case 'pack':
                $formSta = 4;
                break;
            default:break;
	    }
	    //获取基本属性
	    $sql_base = "select IntIdA,TabMId,ProAId,TabNam,TabUDa,TabCTm,imgurl,page,CirSmp,ImpSta,CasSta,TabEls,TabTyp,TabDTm,TabSta from table_mes where IntIdA = '".$FormId."' and TabSta = '".$formSta."'";
        $data['base'] = $this->db->query($sql_base)->result_array();
        
        //获取流转属性
        $sql_cir = "select CirOne,CirTwo,CirThr,CirFor,CirFiv,CirSix,CirSen,CirEig,CirNin,CirTen from circle_true where CirSmp = '".$data['base'][0]['CirSmp']."' ";
        $cirMes = $this->db->query($sql_cir)->result_array();
        if(isset($cirMes[0]))
        {
            $CirKey = array_keys($cirMes[0]);
            $data['cirDetali'] = array();
            $data['cirNum'] = 0;
            for($i=0;$i<10;$i++)
            {
                //如果这个键有对应的值
                if($cirMes[0][$CirKey[$i]])
                {
                    $sql_cirDet = "select DepIdS,PeoLit,SigSta,SigCTm,MesCTm,MesOrd,SigUrl from circle_td where MesSmp = '".$cirMes[0][$CirKey[$i]]."' and MesSta = 0";
                    $CircliMes = $this->db->query($sql_cirDet)->result_array();
                    $data['cirDetali'][] = $CircliMes[0];
                    $data['cirNum']++;
                }
            }
        }
        
        //获取提醒设置
        
	    return $data;
	}
	
	//获取表单的历史信息
	public function FormgetHis($FormId)
	{
	    //获取操作记录
        $sql_his = "select HisNam,HisTim,HisPeo,HisEls,HisSig from table_his where IntIdA = '".$FormId."' order by HisTim ";
	    $data = $this->db->query($sql_his)->result_array();
	    return $data;
	}
	
}
