<?php
	require("conn.php");
	
	$account=$_POST["account"];
	$password=$_POST["password"];
	$mobile=$_POST["mobile"];
	$my_name=$_POST["my_name"];

	
	if($account){
	$sql = "select * from user where UseAcc='".$account."' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$jsonresult='该账号已被注册了,请更换!';
	} else {
		$sql = "select * from user where UsePho='".$mobile."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$jsonresult='该手机已被注册，请更换!';
		} else{
//			$sql = "select * from 用户信息 where 邮箱='".$email."'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				$jsonresult='该邮箱已被注册,请更换!';
			} else{
				$sqli = "insert into user (UseAcc,UseKey,UsePho,UsePeo) values ('$account', '$password', '$mobile' , '$my_name' )";
				if ($conn->query($sqli) === TRUE) {
					$jsonresult='success';
				} else {
					$jsonresult='error';
				}
			}
		}
	}	
	$json = '{"result":"'.$jsonresult.'"		
				}';
	echo $json;
	$conn->close();

	}
?>