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
    }
    
    /*
     * 页面显示
     */
    //草稿文件显示
    public function formShow_Draf()
    {
        $data['table_mes'] = $this->form->check();
        $this->load->view('form_draf.html',$data);
    }
    //签批文件显示
    public function formShow_Sign()
    {
        $this->load->view('form_sign.html');
    }
    //驳回文件显示
    public function formShow_Rejt()
    {
        $this->load->view('form_rejt.html');
    }
    //逾期文件显示
    public function formShow_Over()
    {
        $this->load->view('form_over.html');
    }
    //归集文件显示
    public function formShow_Pack()
    {
        $this->load->view('form_pack.html');
    }
    
}
