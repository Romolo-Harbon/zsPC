<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller{
    /*
     * 公用函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Document_model','doc');
    }
    /*
     * 显示页面
     * 
     */
        /*
         * API:
         * FileType->文档类型{
         *      TypNam->类型名
         * }
         * 
         */
    //草稿文件显示
    public function docShow_Draf()
    {
        $data['FileType'] = $this->doc->File_SelType();
        $this->load->view('doc_draf.html',$data);
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
    /*
     * 功能实现
     */
    public function Doc_AddNew()
    {
//      wrong('ok');
    }
    
}
