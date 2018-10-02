<?php
    require'../conn.php';
    $sql_Cir = "select DepIdS from circle_td where SigSta = 0 and CirSmp = '1535337373547' order by id asc";
    $result_Cir = $conn->query($sql_Cir)->fetch_assoc();
    print_r ($result_Cir);
//  if($result_Cir['DepIdS'] == $RolIdS)
//  {
//      $data['data'][$i]['id'] = $row['id'];
//      $data['data'][$i]['TabNam'] = $row['TabNam'];
//      $data['data'][$i]['TabCTm'] = $row['TabCTm'];
//      $data['data'][$i]['TabDTm'] = $row['TabDTm'];
//      $i++;
//  }
    
    

    
