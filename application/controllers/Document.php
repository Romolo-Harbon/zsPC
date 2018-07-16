<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller{
    //草稿文件显示
    public function docShow_Draf()
    {
        $this->load->view('doc_draf.html');
    }
    //签批文件显示
    public function docShow_Sign()
    {
        $this->load->view('doc_sign.html');
    }
    //废止文件显示
    public function docShow_Rejt()
    {
        $this->load->view('doc_rejt.html');
    }
    //逾期文件显示
    public function docShow_Over()
    {
        $this->load->view('doc_over.html');
    }
    //归集文件显示
    public function docShow_Pack()
    {
        $this->load->view('doc_pack.html');
    }
    
}
