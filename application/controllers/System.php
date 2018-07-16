<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller{
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
        $this->load->view('system_fmty.html');
    }
    //文档类型定义
    public function systemShow_DcTy()
    {
        $this->load->view('system_dcty.html');
    }
    
}
