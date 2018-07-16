<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    /*
     * 显示登录页面
     */
    public function index()
    {
        $this->load->helper('form');
        $this->load->view('login.html');
    }
    /*
     * 账号验证和登录系统
     */
    public function loginSys()
    {
      	//载入验证类
    	$this->load->library('form_validation');
		//设置规则
		$this->form_validation->set_rules('account','用户账号','required|min_length[5]');
		$this->form_validation->set_rules('password','密码','required|min_length[5]');
		//执行验证
		$status = $this->form_validation->run();		
		if($status)
		{
			$account = $this->input->post('account');
			$UseKey = $this->input->post('password');
			$this->load->model('login_model','login');
			$UseNam=$this->login->checkAccount($account);
			if(!$UseNam || $UseNam[0]['UseKey']!=$UseKey)
			{
				error('login/index',"账号不存在或密码错误！");
			}
			else
			{
				echo 'hello';	
			}
    	}else
    	{
    		$this->load->helper('form');
        	$this->load->view('login.html');
    	}
	}

	/*
	 * 注册动作
	 */
	public function register()
	{
		//载入验证类	
		$this->load->library('form_validation');
		//设置规则
		$this->form_validation->set_message('matches', '两次密码不相同');		
		$this->form_validation->set_rules('UsePho','手机号码','required|exact_length[11]|is_unique[user.UsePho]',array('is_unique' => '此手机号码已被注册'));
		$this->form_validation->set_rules('UseNam','账号','required|min_length[6]|max_length[11]|is_unique[user.UseNam]',array('is_unique' => '此账号已被注册'));
		$this->form_validation->set_rules('UseKey','密码','required|min_length[6]|max_length[11]');
		$this->form_validation->set_rules('surpasswod','确认密码','required|min_length[6]|max_length[11]|matches[UseKey]');
		//执行验证
		$status = $this->form_validation->run();
		//	var_dump($status);die;
		if($status)
		{
			$data = array
			(
			 	'UsePho' => $this->input->post('UsePho'),
			 	'UseNam' => $this->input->post('UseNam'),
			 	'UseKey' => $this->input->post('UseKey')
			 );
			$this->load->model('login_model','login');
			$this->login->register($data);
			success('login/index','注册成功');
		}
		else
		{
			wrong('注册失败');
			$this->load->helper('form');
        	$this->load->view('login.html');	
		}
	}
	 /*
	  * 重置密码动作
	  */
	public function reset()
	{
	    $this->load->library('form_validation');
		$this->form_validation->set_message('matches', '两次密码不相同');
		$this->form_validation->set_rules('phone','手机号码','required');
		$this->form_validation->set_rules('NewUseKey','新密码','required|min_length[6]|max_length[11]');
		$this->form_validation->set_rules('newpasswod','确认新密码','required|min_length[6]|max_length[11]|matches[NewUseKey]');
		$status=$this->form_validation->run();
		if($status)
		{								
			$phone = $this->input->post('phone');	
			$this->load->model('login_model','login');
			$UsePho=$this->login->checkphone($phone);	
			if(!$UsePho)
			{
				wrong('手机号码不存在');
				$this->load->helper('form');
				$this->load->view('login.html');
			}
			else
			{
				$this->load->model('login_model','login');
				$UsePho=$this->input->post('phone');
				$UseKey=$this->input->post('NewUseKey');
				$data=array
				(
					'UseKey'=>$UseKey
				);
				$data['user']=$this->login->rset($UsePho,$data);
				success('login/index', '修改成功');
			}
		}
		else
		{
			wrong('修改失败');
			$this->load->helper('form');
			$this->load->view('login.html');
		}		
	}
}