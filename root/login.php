<?php
	require("conn.php");
	$account=$_POST["account"];
	$password=$_POST["password"];	
	
	$sql = "select * from user where UseAcc='".$account."'";
	$result = $conn->query($sql);
	
	$row = $result->fetch_assoc();
	
	if($password==$row["UseKey"])	
	{
		$jsonresult='success';

	}else{
		$jsonresult='error';
		$shji='';
	}	
	$json = '{"result":"'.$jsonresult.'"
				}';
	echo $json;
	$conn->close();	
		
//	print_r($result);
//	var_dump($result);
//	if($result->num_rows>0){
//		while($row = $result->fetch_assoc()){
//			
//		}
//	}
	
	
?>