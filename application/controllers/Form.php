<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller{
    //草稿文件显示
    public function formShow_Draf()
    {
        $this->load->view('form_draf.html');
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
