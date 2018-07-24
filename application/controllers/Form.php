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
        $data['typeForm'] = $this->system->TypeM_selectMes('type_form');
        $this->load->view('form_draf.html',$data);
    }
    //签批文件显示
    public function formShow_Sign()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes('type_form');
//      $data['table_mes'] = $this->form->formDraf_Sel(1);
        $this->load->view('form_sign.html',$data);
    }
    //驳回文件显示
    public function formShow_Rejt()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes('type_form');
//      $data['table_mes'] = $this->form->formDraf_Sel(2);
        $this->load->view('form_rejt.html',$data);
    }
    //逾期文件显示
    public function formShow_Over()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes('type_form');
//      $data['table_mes'] = $this->form->formDraf_Sel(3);
        $this->load->view('form_over.html',$data);
    }
    //归集文件显示
    public function formShow_Pack()
    {
        $data['typeForm'] = $this->system->TypeM_selectMes('type_form');
        $this->load->view('form_pack.html',$data);
    }
    /*
     * 表单列表显示
     */
    //按模板查询
    public function FormList()
    {
        $MId = $this->uri->segment(3);
        $Type = $this->uri->segment(4);
        $MesSta = 4;
        if($Type == 'draft'){
            $MesSta = 0;
        }
        $data['aaData'] = $this->form->TreeShowSelect($MId,$MesSta);
        $i=1;
        foreach($data['aaData'] as &$v)
        {
            $v['rowNum'] = $i;
            $v['checkBox'] = "<label class='pos-rel'><input type='checkbox' class='ace'/><span class='lbl'></span></label>";
            $i++;
        }
        $json = json_encode($data);
        echo $json;
//      echo $data['formMes'];
    }
    //按状态查询
    public function FormSta()
    {
        $Type = $this->uri->segment(4);
        switch($Type)
        {
            case 'sign':$MesSta = 1;break;
            case 'rejt':$MesSta = 2;break;
            case 'over':$MesSta = 3;break;
            default:break;
        }
        $data['aaData'] = $this->form->formDraf_Sel($MesSta);
        $i=1;
        foreach($data['aaData'] as &$v)
        {
            $v['rowNum'] = $i;
            $v['checkBox'] = "<label class='pos-rel'><input type='checkbox' class='ace'/><span class='lbl'></span></label>";
            $i++;
        }
        $json = json_encode($data);
        echo $json;
//      echo $data['formMes'];
    }
    
    
    
}
