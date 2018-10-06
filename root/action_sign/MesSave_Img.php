<?php
    require('../conn.php');
    //获取用户信息
    session_start();
    $RolIdS = $_SESSION['RolIdS'];//角色名
    $UseId = $_SESSION['useId'];//用户id
//  //获取表单信息
    $formId = $_POST['formId'];//表单id
//  //获取签名信息
    $SignPX= $_POST['SignPX'];//签名X坐标
    $SignPY = $_POST['SignPY'];//签名Y坐标
    $FormW = $_POST['FormW'];//表单宽
    $FormH = $_POST['FormH'];//表单高
    $SignW = $_POST['SignW'];//签名宽
    $SignH = $_POST['SignH'];//签名高
    $PageFinal = $_POST['PageFinal'];//签名保存位置
    $SignFinal = $_POST['SignFinal'];//签名保存地址
    $SignDate = date('Y-m-d H:i:s');//签名时间

//  $UseId = '1';
//  $RolIdS = '4';
//  $formId = '55';
//  $SignPX= '187';
//  $SignPY = '320';
//  $FormW = '351';
//  $FormH = '497';
//  $SignW = '25';
//  $SignH = '15';
//  $PageFinal = '1';
//  $SignFinal = '9';
//  $SignDate = date('Y-m-d H:i:s');
    
    require'../conn.php';
    //根据当前的表单id和部门信息更新表单的流转信息
        //更新表【sign_mes】
    $sql_Save = "insert into sign_mes (SignPa,HisIdS,HisFrm,SignPX,SignPY,FormW,FormH,SignW,SignH,PageFinal,SignPeoId,SignDate) values('".$SignFinal."','','0','".$SignPX."','".$SignPY."','".$FormW."','".$FormH."','".$SignW."','".$SignH."','".$PageFinal."','".$UseId."','".$SignDate."')";
    $result_Save = $conn->query($sql_Save);
    
    if($result_Save)
    {
            //查询刚创建的数据的签名id
        $sql_Sel = "select id from sign_mes where SignDate = '".$SignDate."'";
        $result_Sel = $conn->query($sql_Sel)->fetch_assoc();
        
        if($result_Sel)
        {
                //根据表单的流转时间戳和部门id获取流转流程的id
                    //根据表单id获取流转时间戳
            $sql_Stamp = "select CirSmp from table_mes where id = '".$formId."'";
            $result_Stamp = $conn->query($sql_Stamp)->fetch_assoc();
            
            if($result_Stamp)
            {
                        //获取流转流程的id
                $sql_Circle = "select id from circle_td where DepIdS = '".$RolIdS."' and CirSmp = '".$result_Stamp['CirSmp']."' and  SigSta = 0 order by id asc";
                $result_Circle = $conn->query($sql_Circle)->fetch_assoc();
                
                if($result_Circle)
                {
                        //更新流转信息表【circle_td】
                    $sql_Update = "update circle_td set SigSta = '5',SigCTm = '".$SignDate."',SigId='".$result_Sel['id']."' where id = '".$result_Circle['id']."'";
                    $result_Updata = $conn->query($sql_Update);
//                  echo $sql_Update;
                    if(!($result_Updata))
                    {
                        $data['ErrorMes'] = '更新流转信息表出现错误';
                    }
                }else{
                    $data['ErrorMes'] = '获取流转流程的id出现错误';
                }
            }else{
                $data['ErrorMes'] = '获取流转时间戳出现错误';
            }
        }else{
            $data['ErrorMes'] = '查询签名id出现错误';
        }
    }else{
        $data['ErrorMes'] = '保存签名信息出现错误';
    }
    
    //更新表单历史信息
    
    
    $data['status'] = 'error';
    if($result_Updata)
    {
        $data['status'] = 'success';
    }
//  print_r($data) ;
    $json = json_encode($data);
    echo $json;
