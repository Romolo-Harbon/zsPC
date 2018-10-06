<?php
    header('Access-Control-Allow-Origin:*');
    
    /*
     * 显示表单签名信息
     * */    
    require'../conn.php';
    
    //获取表单id
    $CId = $_POST['CId'];
    
    //获取所有流程
    $sql = "select RolNam,SigCTm,id from circle_detail where IntIdA = '".$CId."'";
    $result = $conn->query($sql);
    
    if($result -> num_rows>0)
    {
        $i=0;
        while($row = $result->fetch_assoc())
        {
            $data['his'][$i]['RolNam'] = $row['RolNam'];
            $data['his'][$i]['SigCTm'] = $row['SigCTm'];
            //如果已经签名则获取签名的详情【包括签名人，签名时间,备注，结果】
            
            $i ++;
        }
    }
    
    echo '123';
