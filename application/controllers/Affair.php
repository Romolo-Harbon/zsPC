<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affair extends CI_Controller{
    /*
     * 公用函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Affair_model','affair');
    }
    //我的工程显示
    public function affairShow_Proj()
    {
        $this->load->view('affair_proj.html');
    }
    //待办事项显示
    public function affairShow_Want()
    {
        $this->load->view('affair_want.html');
    }
    //重要文件显示
    public function affairShow_Impt()
    {
        $this->load->view('affair_impt.html');
    }
    //紧急文件显示
    public function affairShow_Cras()
    {
        $this->load->view('affair_cras.html');
    }
    //归档文件显示
    public function affairShow_Pack()
    {
        $this->load->view('affair_pack.html');
    }
    /*
     * 信息查询
     */
    //信息查询[0/待办事项,1/重要文件,2/紧急文件,3/归档文件]
    public function affair_MesShow(){
        $mesType = $this->uri->segment(3);
        //查询归集文件
        if($mesType == 3){
            $data['aaData'] = $this->affair->affairShow_packDoc($mesType);
            $json = json_encode($data);
            echo  $json;
            die;
        }
        //查询待办、重要或者紧急
        $data = $this->affair->affairShow_table($mesType);
        foreach($data['aaData'] as &$v)
        {
            $v['typeC'] = '表单';
            $v['type'] = 'file';
        }
        foreach($data['file'] as &$v)
        {
            $v['typeC'] = '文档';
            $v['type'] = 'doc';
            $data['aaData'][] = $v;
        }
        //销毁数组
        unset($data['file']);
        $json = json_encode($data);
        echo $json;
    }
    
    //获取选中的文件的信息
    public function MesSel()
    {
        $id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        echo $id.'/'.$type;
    }
    /*
     * 我的工程
     */
    //关于权限-》查询
    public function accountPach()
    {
//      $projectId = $this->uri->segment(3);
        $projectId = 1;
        $this->load->model('MesContro_model','mescon');
        $data = $this->mescon->getProAccMes($projectId);
        
        $json = json_encode($data);
        echo $json;
    }
    
    
}
