<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    //显示登录页面
    public function index()
    {
        $this->load->view('login.html');
    }
    //账号验证和登录系统
    public function loginSys()
    {
        
    }
//  //登录系统
//  public function login()
//  {
//      
//  }

}
