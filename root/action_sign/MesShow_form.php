<?php
    header("Access-Control-Allow-Origin: *");
    require('../conn.php');
    //获取传值
    $CId = $_POST['CId'];
    //获取数据库基本数据
    $sql = "select id,IntIdA,TabNam,CirSmp,ImgUrl,page from table_mes  where id = '".$CId."'";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {
        while($row = $result->fetch_assoc())
        {
            $data['data']['id'] = $row['id'];
            $data['data']['IntIdA'] = $row['IntIdA'];
            $data['data']['TabNam'] = $row['TabNam'];
            $data['data']['imgurl'] = $row['ImgUrl'];
            $data['data']['page'] = $row['page'];
        }
    }
    
    if(isset($data['data']['imgurl']))
    {
        $data['status'] = 'success';
        $json = json_encode($data);
        echo $json;
        return 0;
    }
    $data['status'] = 'fail';
    $json = json_encode($data);
    echo $json;
