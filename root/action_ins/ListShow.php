<?php
    require("../conn.php");
    //获取类型信息
    function GetMes_Type($type)
    {
        $sign = 1;
        if($type=='tab')
        {
            $sign = 0;
        }
        $sql_GetMes_Type = "select id,TypNam from type_mes where TypeFT = ".$sign." order by id";
        return $sql_GetMes_Type;
    }
    //获取类型下的详细信息
    function GetMes_List($type,$TypeName)
    {
        $sign = 1;
        if($type=='tab')
        {
            $sign = 0;
        }
        //根据类型名称查出类型的id
        $sql_GetId_Type = "select id from type_mes where TypeFT = ".$sign." and TypNam = '".$TypeName."' ";
        return $sql_GetId_Type;
    }
    
    $falg = $_POST['falg'];
//  $falg = 'listMesType_detail';
    switch($falg){
        //获取表单类型信息
        case 'listMesType':
            $type = $_POST['type'];
//          $type = 'tab';
            $sql = GetMes_Type($type);
            $result = $conn->query($sql);
            if($result->num_rows>0)
            {
                $i = 0;
                while($row = $result->fetch_assoc())
                {
                    $data['data'][$i]['id'] = array($row['id']);
                    $data['data'][$i]['TypNam'] = array($row['TypNam']);
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
        case 'listMesType_detail':
            $type = $_POST['type'];
            $TypeName = $_POST['typeNaem'];
//          $type = 'tab';
//          $TypeName = '验收档案';
            $sql = GetMes_List($type,$TypeName);
            $result = $conn->query($sql)->fetch_assoc();
            $sql_GetMes_List = "select id,TabNam,TabCTm,TabDTm from table_mes where TabTyp = ".$result['id']." order by TabDTm";
            $result = $conn->query($sql_GetMes_List);
            if($result->num_rows>0)
            {
                $i = 0;
                while($row = $result->fetch_assoc())
                {
                    $data['data'][$i]['id'] = array($row['id']);
                    $data['data'][$i]['TabNam'] = array($row['TabNam']);
                    $data['data'][$i]['TabCTm'] = array($row['TabCTm']);
                    $data['data'][$i]['TabDTm'] = array($row['TabDTm']);
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
        default:break;
    }
    
    

    
