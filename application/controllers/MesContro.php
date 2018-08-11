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
    }
    /*
     * 功能函数
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
     * 流转属性设置
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
    
}