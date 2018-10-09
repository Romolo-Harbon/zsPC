<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller{
    /*
     * 公共函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_model','system');
        $this->load->model('MesContro_model','MesCon');
    }
    /*
     * 页面显示
     */
        //部门人员管理
        public function systemShow_Depm()
        {
            $data['PeoMes'] = $this->system->SelPeoMes();
            $this->load->view('system_depm.html',$data);
        }
        //手机用户管理
        public function systemShow_Phoe()
        {
            $this->load->view('system_phoe.html');
        }
        //表单类型定义
        public function systemShow_FmTy()
        {
            //部门信息
            $data['departMes'] = $this->system->RoleM_selectMes();
            $this->load->view('system_fmty.html',$data);
        }
        //文档类型定义
        public function systemShow_DcTy()
        {
            //部门信息
            $data['departMes'] = $this->system->RoleM_selectMes();
            $this->load->view('system_dcty.html',$data);
        }
    
    /*
     * 功能实现---表单和文档类型
     */
    //新增
    public function Type_SetNew()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('TypeName','类型名','required');
        $status = $this->form_validation->run();
        if($status) {
            $Type = $this->input->post('Type');
            if($Type == 'systemShow_DcTy') {
                $TypeS = 1;
                
            }else {
                $TypeS = 0;
            }
            $data = array(
                'TypCTm' => date('Y-m-d H:i:s'),
                'TypCPe' => $_SESSION['UsePeo'],
                'AccIdA' => $_SESSION['UserAId'],
                'TypNam' => $this->input->post('TypeName'),
                'TypEls' => $this->input->post('TypeElse'),
                'TypeFT' => $TypeS,
            );
            $data = $this->system->TypeM_addNew('type_mes',$data);
            if($data['rowNum'])
            {   
                //如果新建文档类型则默认新建文档流程
//              if($Type)
//              {
//                  $CirMes = '';
//                  $this->MesCon->CirSave_New($data['NId'],$CirMes);
//              }
                success('System/'.$Type,'类型新建成功');
            }
        }
        else{
            error('System/'.$Type,'请将类型名填写完整');
        }
    }
    //删除
    public function Type_Del()
    {
        $id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        //如果是文档类型修删除
        if($type == 'doc') {
            $this->system->TypeDel($id,'type_mes');
            success('System/systemShow_DcTy','已删除指定类型');
        }
        //如果是表单类型删除
        $this->system->TypeDel($id,'type_mes');
        success('System/systemShow_FmTy','已删除指定类型');
    }
    //修改
    public function Type_Edit(){
        //待添加验证
        $TypeId = $this->input->post('TypeId');
        $Type = $this->input->post('Type');
        $data = array(
            'TypCTm' => date('Y-m-d H:i:s'),
            'TypCPe' => $_SESSION['UsePeo'],
            'AccIdA' => $_SESSION['UserAId'],
            'TypNam' => $this->input->post('TypeName'),
            'TypEls' => $this->input->post('TypeElse'),
        );
        $this->system->TypeM_Edit('type_mes',$data,$TypeId);
        success('System/'.$Type,'类型修改成功');
    }
    //显示
    public function Type_ShowMes()
    {
        $Type = $this->uri->segment(4);
        $TabName = 1;
        if($Type == 'form'){
            $TabName = 0;
        }
        $data['aaData'] = $this->system->TypeM_selectMes($TabName);
        $i=1;
        foreach($data['aaData'] as &$v)
        {
            $v['rowNum'] = $i;
            $ConMES = "MesDel(".$v['id'].")";
            $v['control'] = "<button onclick='".$ConMES."'>删除</button>";
            $i++;
        }
        $json = json_encode($data);
        echo $json;
    }
    /*
     * 功能实现---部门及人员设置
     */
    //显示部门信息
    public function Role_ShowMes()
    {
        $data['aaData'] = $this->system->RoleM_selectMes();
        $i=1;
        foreach($data['aaData'] as &$v)
        {
            $v['rowNum'] = $i;
            $ConMES = "MesDel(".$v['id'].")";
            $v['control'] = "<button onclick='".$ConMES."'>删除</button>";
            $i++;
        }
        $json = json_encode($data);
        echo $json;
    }
    //新增部门信息
    public function Role_SetNew()
    {
        //载入验证类
        $this->load->library('form_validation');
        //设置规则
        $this->form_validation->set_rules('DepaName','部门名称','required|is_unique[role.RolNam]',array('is_unique' => '此部门名称已经存在'));
        //执行验证
        $status = $this->form_validation->run();
        if($status)
        {
            $data = array(
                'RolCTm' => date('Y-m-d H:i:s'),
                'RolCPe' => $_SESSION['UsePeo'],
                'AccIdA' => $_SESSION['UserAId'],
                'RolNam' => $this->input->post('DepaName'),
                'RolEls' => $this->input->post('DepaElse'),
            );
            $this->system->RoleM_addNew($data);
            success('System/systemShow_Depm','部门新建成功');
        }
        else
        {
            error('System/systemShow_Depm','请正确填写部门名称，勿必保证部门名不重合');
        }
    }
    //删除部门信息
    public function Role_Del()
    {
        $id = $this->uri->segment(3);
        $status = $this->system->RoleDel($id);
        $data['status'] = 'fail';
        if($status)
        {
            $data['status'] = 'success';
        }
        $json = json_encode($data);
        echo $json;
    }
    //修改部门信息
    public function Role_Edit()
    {
        //待添加验证
        $TypeId = $this->input->post('TypeId');
        $data = array(
            'RolCTm' => date('Y-m-d H:i:s'),
            'RolCPe' => $_SESSION['UsePeo'],
            'AccIdA' => $_SESSION['UserAId'],
            'RolNam' => $this->input->post('TypeName'),
            'RolEls' => $this->input->post('TypeElse'),
        );
        $this->system->RoleM_Edit($data,$TypeId);
        success('System/systemShow_Depm','部门修改成功');
    }
    //查询部门基本信息及人员信息
    public function RoleLinUse_Sel()
    {
        $TypeId = $this->input->post('TypeId');
//      $TypeId = 3;
        
        $data = $this->system->SelPeoMesED($TypeId);
        $json = json_encode($data);
        echo $json;
    }
    //保存部门人员信息设置
    public function RoleLinUse_Set()
    {
        $RoleId = $this->input->post('RId');
        $PeoMes = $this->input->post('UseLim');
        
//      $RoleId = 3;
//      $PeoMes = array('羊=>yangshen');
        //获取时间戳
        list($t1, $t2) = explode(' ', microtime());
        $CirSmp = (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
        //删除本部门绑定的所有的用户信息
        $this->system->RoleLinUse_Del($RoleId,$CirSmp);
        //创建新的用户部门信息
        for($i = 0;$i < count($PeoMes);$i++)
        {
            $UseMes = explode('=>',$PeoMes[$i]);
            $data['sta'] = $this->system->RoleLinUse_Set($RoleId,$UseMes[0],$UseMes[1],$CirSmp);
        }
        $json = json_encode($data);
        echo $json;
    }
    /*
     * 功能实现---用户管理
     */
    //账号显示
    public function Account_ShowMes()
    {
        $data['aaData'] = $this->system->Account_ShowMes();
        $i = 1;
        foreach($data['aaData'] as &$v)
        {
            $v['rowNum'] = $i;
            $i++;
        }
        $json = json_encode($data);
        echo $json;
    }
    //账号详情显示
    public function Account_ShowDetail()
    {
        $MId = $this->input->post('MesId');
//      $MId = 15;
        $data['id'] = $MId;
        $data['AccountMes'] = $this->system->Account_ShowDetail($MId);
        $json = json_encode($data);
        echo $json;
    }
    //账号注销通过删除
    public function Account_ChangeSta()
    {
        $ActType = $this->input->post('ActType');
        $MId = $this->input->post('MId');
        $time = date('Y-m-d H:i:s');
        //判断账号状态
        switch($ActType)
        {
            //注销
            case 'loginOut':
                $AccSta = 2;
                break;
            //通过
            case 'pass':
                $AccSta = 1;
                break;
            //删除
            case 'del':
                $AccSta = 3;
                break;
            default:break;
        }
        //创建账号信息数组
        $MesData = array(
            'UseSta' => $AccSta,
            'UsePPe' => $_SESSION['UsePeo'],
            'UsePTm' => $time,
            'UseCPe' => $_SESSION['UsePeo'],
            'UseCTm' => $time,
        );
        $data['peo'] = $_SESSION['UsePeo'];
        $data['time'] = $time;
        $data['mes'] = $this->system->Account_ChangeSta($MId,$MesData);
        if($data['mes'])
        {
            unset($data['mes']);
            $json = json_encode($data);
            echo $json;
        }
    }
}
