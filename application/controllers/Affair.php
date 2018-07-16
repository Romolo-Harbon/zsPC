<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Affair extends CI_Controller{
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
    
}
