<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller{
    /*
     * 公共函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_model','system');
    }
    /*
     * 页面显示
     */
        //审批流程设置
        public function systemShow_Care()
        {
            $this->load->view('system_care.html');
        }
        //部门管理
        public function systemShow_Depm()
        {
            $this->load->view('system_depm.html');
        }
        //手机用户管理
        public function systemShow_Phoe()
        {
            $this->load->view('system_phoe.html');
        }
        //模板管理
        public function systemShow_FoMa()
        {
            $this->load->view('system_form.html');
        }
        //表单类型定义
        public function systemShow_FmTy()
        {
            $data['TypeForm'] = $this->system->TypeM_selectMes();
            $this->load->view('system_fmty.html');
        }
        //文档类型定义
        public function systemShow_DcTy()
        {
            $data['TypeFile'] = $this->system->TypeM_selectMes();
            /*
             * APIMes：
             *      TypeFile->文档信息{
             *          TypNam->类型名
             *          TypCTm->创建时间
             *          TypCPe->创建人
             *          TypEls->类型其他
             * }
             */
            $this->load->view('system_dcty.html',$data);
        }
        
        //手机端滚动通知设置
        public function systemShow_PhAd()
        {
            $this->load->view('system_phad.html');
        }
        //签批字典设置
        public function systemShow_Dicy()
        {
            $this->load->view('system_dicy.html');
        }
    
    /*
     * 功能实现---表单和文档类型
     */
    //新增
    public function Type_SetNew()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('TypeName','类型名','required');
        $status = $this->form_validation->run();
        if($status) {
            $Type = $this->input->post('Type');
            $data = array(
                'TypCTm' => date('Y-m-d H:i:s'),
                'TypCPe' => $_SESSION['UsePeo'],
                'AccIdA' => $_SESSION['UserAId'],
                'TypNam' => $this->input->post('TypeName'),
                'TypEls' => $this->input->post('TypeElse'),
            );
            if($Type == 'systemShow_DcTy') {
                $this->system->TypeM_addNew('type_file',$data);
            }else {
                $this->system->TypeM_addNew('type_form',$data);
            }
            success('System/'.$Type,'类型新建成功');
        }
        else{
            error('System/'.$Type,'请将类型名填写完整');
        }
    }
}
