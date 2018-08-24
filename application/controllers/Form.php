<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller{
    /*
     * 公用函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Form_model','form');
        $this->load->model('System_model','system');
    }
    /*
     * 页面显示
     */
        /*
         * API:
         *    table_mes->表单信息{
         *        id
         *        TabNam->表单名
         * }
         */
        //0草稿,1提交(签批),2驳回,3逾期,4归集,5撤回归集,6重新提交,9删除
    //草稿文件显示
    public function formShow_Draf()
    {
        $this->load->view('form_draf.html');
    }
    //签批文件显示
    public function formShow_Sign()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes(0);
        $this->load->view('form_sign.html',$data);
    }
    //驳回文件显示
    public function formShow_Rejt()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes(0);
        $this->load->view('form_rejt.html',$data);
    }
    //逾期文件显示
    public function formShow_Over()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes(0);
        $this->load->view('form_over.html',$data);
    }
    //归集文件显示
    public function formShow_Pack()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes(0);
        $this->load->view('form_pack.html',$data);
    }
    /*
     * 表单列表显示【不包括草稿部分的信息查询】
     */
    //按状态查询
    public function FormSta()
    {
        $Type = $this->uri->segment(3);
//      $Type = 'sign';
        $data['aaData'] = $this->form->FormSta($Type);
        $i=1;
        foreach($data['aaData'] as &$v)
        {
            $v['rowNum'] = $i;
            $v['checkBox'] = "<label class='pos-rel'><input type='checkbox' class='ace'/><span class='lbl'></span></label>";
            $i++;
        }
        $json = json_encode($data);
        echo $json;
    }
    //按模板查询表单【用于查询已经归档的表单】
    public function FormMod()
    {
        
    }
    //表单信息显示
    public function FormMesLoad()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes(0);
        
        $this->load->view('form_info.html',$data);
    }
    //获取表单的历史信息
    public function FormgetHis()
    {
        $FormId = $this->uri->segment(3);
//      $FormId = '12d9d360-8e6b-49d1-8884-8320c14f014e';
        
        $data['aaData'] = $this->form->FormgetHis($FormId);
        $json = json_encode($data);
        echo $json;
    }
    //获取表单基本信息和流转属性
    public function FormgetBC()
    {
    //如果选中的是接口中的数据，则应该先将数据保存到表单的数据表中
        //获取参数
        $FormId = $this->uri->segment(3);
        $FormType = $this->uri->segment(4);
//      $FormId = '12d9d360-8e6b-49d1-8884-8320c14f014e';
//      $FormType = 'sign';
        //获取信息
        $data = $this->form->FormMesLoad($FormId,$FormType);
        $json = json_encode($data);
        echo $json;
    }
}
