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
    }
    /*
     * 页面显示
     */
        //审批流程设置
//      public function systemShow_Care()
//      {
//          $this->load->view('system_care.html');
//      }
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
        //模板节点管理
        public function systemShow_Form()
        {
            $this->load->view('system_form.html');
        }
        //表单类型定义
        public function systemShow_FmTy()
        {
//          $data['PartMES'] = $this->system->TypeM_selectMes();
            /*
             * APIMes：
             *      TypeFile->表单信息{
             *          id
             *          TypNam->类型名
             *          TypCTm->创建时间
             *          TypCPe->创建人
             *          TypEls->类型其他
             * }
             */
//          $data = json_encode($data);
//          p($data);
            $this->load->view('system_fmty.html');
        }
        //文档类型定义
        public function systemShow_DcTy()
        {
            $data['TypeFile'] = $this->system->TypeM_selectMes('type_file');
            /*
             * APIMes：
             *      TypeFile->文档信息{
             *          id
             *          TypNam->类型名
             *          TypCTm->创建时间
             *          TypCPe->创建人
             *          TypEls->类型其他
             * }
             */
            $this->load->view('system_dcty.html',$data);
        }
        //签批字典设置
        public function systemShow_Dicy()
        {
            $this->load->view('system_dicy.html');
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
            $data = array(
                'TypCTm' => date('Y-m-d H:i:s'),
                'TypCPe' => $_SESSION['UsePeo'],
                'AccIdA' => $_SESSION['UserAId'],
                'TypNam' => $this->input->post('TypeName'),
                'TypEls' => $this->input->post('TypeElse'),
            );
            if($Type == 'systemShow_DcTy') {
                $this->system->TypeM_addNew('type_file',$data);
            }else {
                $this->system->TypeM_addNew('type_form',$data);
            }
            success('System/'.$Type,'类型新建成功');
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
            $this->system->TypeDel($id,'type_file');
            success('System/systemShow_DcTy','已删除指定类型');
        }
        //如果是表单类型删除
        $this->system->TypeDel($id,'type_form');
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
        if($Type == 'systemShow_DcTy') {
            $this->system->TypeM_Edit('type_file',$data,$TypeId);
        }else {
            $this->system->TypeM_Edit('type_form',$data,$TypeId);
        }
        success('System/'.$Type,'类型修改成功');
    }
    /*
     * 功能实现---表单类型之工作流
     */
    public function Type_ShowMes()
    {
        $Type = $this->uri->segment(4);
        $TabName = 'type_file';
        if($Type == 'form'){
            $TabName = 'type_form';
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
     * 功能实现---表单模板
     */
    //显示
    public function TreeShow()
    {
        $data['tree'] = $this->system->TreeShow();
        $json = json_encode($data['tree']);
        echo $json;
    }
    //保存修改
    public function TreeEditSave ()
    {
        $DelNoid = $this->input->post('DelNoid');
        $AddNoid = $this->input->post('AddNoid');
        /*
         * 数据格式：
         * $DelNoid = '21/23/99999999';
         * $AddNoid = '99999999,8,123/100000000,8,123/100000001,8,123/100000002,10,123/12,12,123/21,12,123';
         */
        if($DelNoid)
        {
            $DelNoidArr = explode('/',$DelNoid);
        }
        else
        {
            $DelNoidArr = array();
        }
        if($AddNoid)
        {
            $AddNoidArr = explode('/',$AddNoid);
            //添加
            foreach($AddNoidArr as $i){
                $AddNoidArr2 = explode(',',$i);
                if(in_array($AddNoidArr2[0],$DelNoidArr))
                {
                    continue;
                }
                $data = array(
                    'NodNam'=>$AddNoidArr2[2],
                    'ParIdS'=>$AddNoidArr2[1],
                    'NodCPe'=>$_SESSION['UsePeo'],
                    'NodCTm'=>date('Y-m-d H:i:s'),
                );
                $this->system->TreeEditSaveN($data);
            }
        }
        //删除
        foreach($DelNoidArr as $y){
            if($y>(int)'999999999')
            {
                continue;
            }
            $data = array(
                'id'=>$y,
            );
            $dataPId = array(
                'ParIdS'=>$y,
            );
            $this->system->TreeEditSaveD($data,$dataPId);
        }
    }
    /*
     * 功能实现---部门及人员设置
     */
    //信息显示
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
    //新增
    public function Role_SetNew()
    {
        //待添加验证
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
    //删除
    public function Role_Del()
    {
        $id = $this->uri->segment(3);
        $this->system->RoleDel($id);
        success('System/systemShow_Depm','已删除指定类型');
    }
    //修改
    public function Role_Edit(){
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
    //部门人员信息查询【已经分配】
    public function RoleLinUse_Sel()
    {
//      $TypeId = $this->input->post('TypeId');
//      $data['PeoMesEd'] = $this->system->SelPeoMesED($TypeId);
//      $json = json_encode($data['PeoMesEd']);
//      echo $jsons;
    }
    //保存部门设置
    public function RoleLinUse_Set()
    {
        $RoleId = $this->input->post('RId');
        $PeoMes = $this->input->post('duallistbox_demo1[]');
        for($i=0;$i<count($PeoMes);$i++)
        {
            $UseMes = explode('>',$PeoMes[$i]);
            $this->system->RoleLinUse_Set($RoleId,$UseMes[0],$UseMes[1]);
        }
        success('System/systemShow_Depm','部门人员修改成功');
    }
    
}
