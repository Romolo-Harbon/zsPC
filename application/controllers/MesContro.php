<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MesContro extends CI_Controller{
    /*
     * 公用函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MesContro_model','MesCon');
        $this->load->model('Form_model','form');
        $this->load->model('System_model','system');
        
    }
    /*
     * 功能函数-改变状态
     */
    //改变状态【提交，归集，驳回，重新提交，撤回归集】
    public function change_sta(){
        //0草稿,1提交(签批),2驳回,3逾期,4归集,5撤回归集,6重新提交,9删除
        
        //接收数据并判断需要更新哪个表
        $MesId = $this->input->post('MesId');
        $Type = $this->input->post('MesType');
        $CT = $this->input->post('CT');
        
        $FormN = 'doc_mes';
        if($Type == 'form') {
            $FormN = 'table_mes';
        }
        $MesId = explode(',',$MesId);
        $this->MesCon->change_sta($FormN,$MesId,$CT);
        switch ($CT)
        {
            case 0:$action = '撤回归集';break;
            case 1:$action = '提交';break;
            case 2:$action = '驳回';break;
            case 4:$action = '归集';break;
            case 5:$action = '撤回归集';break;
            case 6:$action = '重新提交';break;
            case 9:$action = '删除';break;
            default:break;
        }
        echo $action;
    }
    
    /*
     * 功能函数-流转属性设置
     */
    //新建流转属性
    public function CirSave_New()
    {
        $TypeId = $this->input->post('TypeId');
        $CirMes = $this->input->post('data');
        $data['mes'] = $this->MesCon->CirSave_New($TypeId,$CirMes);
        if($data['mes'])
        {
            $data['success'] = 'ok';
        }
        unset($data['mes']);
        $json = json_encode($data['success']);
        echo $json;
    }
    //显示流转属性
    public function CirMes_Show()
    {
        $TypeId = $this->input->post('TypeId');
        $data['mes'] = $this->MesCon->CirMes_Show($TypeId);
        $json = json_encode($data);
        echo $json;
    }
    //修改流转属性
    public function CirSave_Change()
    {
//      $TypeId = $this->input->post('TypeId');
//      $CirMes = $this->input->post('data');
//      
        $data['success'] = 'ok';
//      $data['sql'] = $this->MesCon->CirSave_New($TypeId,$CirMes);
        $json = json_encode($data);
        echo $json;
    }
    /*
     * 功能函数-获取树节点
     * */
    public function GetTreeNode()
    {
        $url = 'http://112.74.34.150:8080/TongXinweb/Tree/AllNode';
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
        curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
        $file_contents = curl_exec ( $ch );
        //json解码
        $data = json_decode($file_contents,true);
        $array = array();
        $arrayNodeId = array();
        for ($i=0;$i<count($data['data']);$i++)
        {
            //如果这个表单模板已经存在
            if (! in_array($data['data'][$i]['nodeId'],$arrayNodeId))
            {
                $array[] = $data['data'][$i];
                $arrayNodeId[] = $data['data'][$i]['nodeId'];
            }
        }
        $json = json_encode($array);
        echo $json;
        
        curl_close ( $ch );
    }
    //按模板查询表单信息
    public function FormList()
    {
        //获取未作修改的数据
//      $url = 'http://112.74.34.150:8080/TongXinweb/form/getFormByPid?projectId=0b5c5b47-0927-48ec-a336-9b925881ec54';
//      $ch = curl_init ();
//      curl_setopt ( $ch, CURLOPT_URL, $url );
//      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
//      curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
//      curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
//      $file_contents = curl_exec ( $ch );
//      //json解码
//      $data = json_decode($file_contents,true);
//      $array = array();
//      foreach ($data['data'] as &$v)
//      {
//          $v['TabSta'] = 9;
//          $v['checkBox'] = "<label class='pos-rel'><input type='checkbox' class='ace'/><span class='lbl'></span></label>";
//          $array[] = $v;
//      }
        //获取作了修改但是未提交的数据
            //获取传递的数据
//      $MId = $this->uri->segment(3);
        $MId = '62f5a0f8-7d0b-4cf0-b9a3-be8fb80cf137';
//      $data = $this->form->TreeShowSelect($MId,0,$PId);
        $data = $this->form->TreeShowSelect($MId,0);
        foreach($data as &$v)
        {
            $v['checkBox'] = "<label class='pos-rel'><input type='checkbox' class='ace'/><span class='lbl'></span></label>";
            $array[] = $v;
        }
        $data['aaData'] = $array;

//      print_r($data['aaData']);
        $json = json_encode($data);
        echo $json;
    }
}