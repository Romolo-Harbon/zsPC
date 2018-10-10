<?php
    require("../conn.php");
    $falg = $_POST['falg'];
//  $falg = 'listMesType';
    $showtime = date("Y-m-d");
//  echo $showtime;
    
    switch($falg){
        //获取表单类型信息
        case 'listMesType':
            $type = $_POST['type'];
            $projectId = $_POST['projectId'];
            $DepIdS = $_POST['RolId'];
//          $type = 'tab';
//          $projectId = '0b5c5b47-0927-48ec-a336-9b925881ec54';
//          $DepIdS = '4';
            
            /*
             * 根据文件类型查询对应的所有类型
             * 根据类型id，项目id，角色id查询表单当前状态视图【sign_check】 ：此项目对应类型对应觉得的应处理信息条数
             */
            //设置文件类型，文档为1，表单为0
            $sign = 1;
            if($type=='tab')
            {
                $sign = 0;
            }
            //获取所有类型
            $sql = "select id,TypNam from type_mes where TypeFT = ".$sign." order by id";
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                $i = 0;
                while($row = $result->fetch_assoc())
                {
                    $data['data'][$i]['id'] = $row['id'];
                    $data['data'][$i]['TypNam'] = $row['TypNam'];
                    //判断表单状态
                    $sql_GetMes = "select id,TabNam,TabCTm,TabDTm,CirSmp,SigSta from sign_check where ProAId = '".$projectId."' and TabSta = 1 order by TabDTm";
                    $result_GetMes = $conn->query($sql_GetMes);
                    if($result_GetMes->num_rows>0)
                    {
                        while($row_GetMes = $result_GetMes->fetch_assoc())
                        {
                            //如果当前日期大于时间期限则判断为逾期，改变表单状态【逾期状态为3】
                            if($row_GetMes['TabDTm'] <= $showtime)
                            {
                                $sql_ChangeSta01 = "update table_mes set TabSta = 3 where id = '".$row_GetMes['id']."'";
                                $result_ChangeSta = $conn->query($sql_ChangeSta01);
                                continue;
                            }
                            //判断表单是不是已经走完签批流程，改变表单状态【归集状态为4】
                            if($row_GetMes['SigSta'] == 5)
                            {
                                $sql_ChangeSta02 = "update table_mes set TabSta = 4 where id = '".$row_GetMes['id']."'";
                                $result_ChangeSta = $conn->query($sql_ChangeSta02);
                                continue;
                            }
                        }
                    }
                    
                    //计算类型对应的表单数量
                    $CountForm = "select COUNT(signId) as num from sign_check where  TabTyp = '".$row['id']."' and TabSta = 1 and ProAId = '".$projectId."' and DepIdS = '".$DepIdS."'";
                    $result_CountForm = $conn->query($CountForm)->fetch_assoc();
                    $data['data'][$i]['Num'] = $result_CountForm['num'];
//                  print_r($data);echo '<br/>';
                    $i++;
                }
                $data['status'] = 'success';
            }
            else{
                $data['status'] = 'fail';
            }
            $json = json_encode($data);
            echo $json;
            break;
            
        //获取表单信息
        case 'listMesType_detail':
            session_start();
            $DepIdS = $_SESSION['RolIdS'];
            $TypeId = $_POST['TypeId'];
            $projectId = $_POST['projectId'];
//          $TypeId = '8';
//          $projectId = '0b5c5b47-0927-48ec-a336-9b925881ec54';
//          $DepIdS = 4;
            
            /*
             * 根据类型id，项目id，文件类型，角色id查询表单当前状态视图【sign_check】 ：此项目对应类型对应觉得的应处理信息条数
             */
            //根据类型id查找表单信息
                //表单查询
            $data['status'] = 'fail';
            $sql_GetMes = "select id,TabNam,TabCTm,TabDTm,CirSmp,SigSta from sign_check where TabTyp = ".$TypeId." and ProAId = '".$projectId."' and TabSta = 1 and DepIdS = '".$DepIdS."' order by TabDTm";
//          $sql_GetMes = "select id,CirSmp,TabDTm,TabNam,TabCTm from sign_check where cast(TabDTm as datetime) >= '$showtime' and TabTyp = ".$TypeId." and ProAId = '".$projectId."' and TabSta = 1 and DepIdS = '".$DepIdS."' order by TabDTm";
            $result_GetMes = $conn->query($sql_GetMes);
            if($result_GetMes->num_rows>0)
            {
                $i = 0;
                $data['row'] = 0;
                while($row = $result_GetMes->fetch_assoc())
                {
                    
                    //否则输出表单
                    $data['CirSmp'][$i] = $row['CirSmp'];
                    $data['data'][$i]['id'] = $row['id'];
                    $data['data'][$i]['TabNam'] = $row['TabNam'];
                    $data['data'][$i]['TabCTm'] = $row['TabCTm'];
                    $data['data'][$i]['TabDTm'] = $row['TabDTm'];
                    $i++;
                }
                $data['row'] = $i;
                
                if($data['row'] > 0)
                {
                    $data['status'] = 'success';
                }
            }
            else
            {
                $data['status'] = 'fail';
            }
            
            $json = json_encode($data);
            echo $json;
            break;
            
            
        case 'listMesType_deta':
            session_start();
            $DepIdS = $_SESSION['RolIdS'];
            $TypeId = $_POST['TypeId'];
            $projectId = $_POST['projectId'];
//          $TypeId = '8';
//          $projectId = '0b5c5b47-0927-48ec-a336-9b925881ec54';
//          $DepIdS = 4;
            
            /*
             * 根据类型id，项目id，文件类型，角色id查询表单当前状态视图【sign_check】 ：此项目对应类型对应觉得的应处理信息条数
             */
            //根据类型id查找表单信息
                //表单查询
            $data['status'] = 'fail';
            $sql_GetMes = "select id,TabNam,TabCTm,TabDTm,CirSmp,TabSta from circle_detail where cast(TabDTm as datetime) >= '$showtime' and TabTyp = ".$TypeId." and DepIdS = '".$DepIdS."' and ProAId = '".$projectId."' order by TabDTm";
//          $sql_GetMes = "select id,CirSmp,TabDTm,TabNam,TabCTm from sign_check where cast(TabDTm as datetime) >= '$showtime' and TabTyp = ".$TypeId." and ProAId = '".$projectId."' and TabSta = 1 and DepIdS = '".$DepIdS."' order by TabDTm";
            $result_GetMes = $conn->query($sql_GetMes);
            if($result_GetMes->num_rows>0)
            {
                $i = 0;
                $data['row'] = 0;
                while($row = $result_GetMes->fetch_assoc())
                {
                    
                    //否则输出表单
                    $data['CirSmp'][$i] = $row['CirSmp'];
                    $data['data'][$i]['id'] = $row['id'];
                    $data['data'][$i]['TabNam'] = $row['TabNam'];
                    $data['data'][$i]['TabCTm'] = $row['TabCTm'];
                    $data['data'][$i]['TabDTm'] = $row['TabDTm'];
                    $data['data'][$i]['TabSta'] = $row['TabSta'];
                    
                    $i++;
                }
                $data['row'] = $i;
                
                if($data['row'] > 0)
                {
                    $data['status'] = 'success';
                }
            }
            else
            {
                $data['status'] = 'fail';
            }
            
            $json = json_encode($data);
            echo $json;
            break;    
            
            //获取表单信息
        case 'listMesType_search':
            session_start();
            $DepIdS = $_SESSION['RolIdS'];
            $SearchVal = $_POST['SearchVal'];
            $TypeId = $_POST['TypeId'];
            $projectId = $_POST['projectId'];
//          $TypeId = '8';
//          $projectId = '0b5c5b47-0927-48ec-a336-9b925881ec54';
//          $DepIdS = 4;
            
            /*
             * 根据类型id，项目id，文件类型，角色id查询表单当前状态视图【sign_check】 ：此项目对应类型对应觉得的应处理信息条数
             */
            //根据类型id查找表单信息
                //表单查询
            $data['status'] = 'fail';
//          $sql_GetMes = "select id,TabNam,TabCTm,TabDTm,CirSmp from table_mes where TabTyp = ".$TypeId." and ProAId = '".$projectId."' and TabSta = 1 order by TabDTm";
//          $sql_GetMes = "select id,CirSmp,TabDTm,TabNam,TabCTm,TabSta from circle_detail where cast(TabDTm as datetime) <= '$showtime' and TabNam LIKE '%".$SearchVal."%' and TabTyp = ".$TypeId." and ProAId = '".$projectId."' and DepIdS = '".$DepIdS."' order by TabDTm";
			$sql_GetMes = "select id,TabNam,TabCTm,TabDTm,CirSmp,TabSta from circle_detail where cast(TabDTm as datetime) >= '$showtime' and TabNam LIKE '%".$SearchVal."%' and TabTyp = ".$TypeId." and DepIdS = '".$DepIdS."' and ProAId = '".$projectId."' order by TabDTm";
            $result_GetMes = $conn->query($sql_GetMes);
            if($result_GetMes->num_rows>0)
            {
                $i = 0;
                $data['row'] = 0;
                while($row = $result_GetMes->fetch_assoc())
                {
                    $data['CirSmp'][$i] = $row['CirSmp'];
                    $data['data'][$i]['id'] = $row['id'];
                    $data['data'][$i]['TabNam'] = $row['TabNam'];
                    $data['data'][$i]['TabCTm'] = $row['TabCTm'];
                    $data['data'][$i]['TabDTm'] = $row['TabDTm'];
                    $data['data'][$i]['TabSta'] = $row['TabSta'];
                    $i++;
                }
                $data['row'] = $i;

                if($data['row'] > 0)
                {
                    $data['status'] = 'success';
                }
            }
            else
            {
                $data['status'] = 'fail';
            }
            
            $json = json_encode($data);
            echo $json;
            break;
        
        default:break;
    }
    
    

    
