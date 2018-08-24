<?php
    //本地连接
	$servername = "127.0.0.1:3306";
	$username = "root";
	$password = "123456";
	$dbname = "tongxweb";
	$conn_API = new mysqli($servername, $username, $password, $dbname);
	if ($conn_API->connect_error) {
		die("Connection failed: " . $conn_API->connect_error);
	}else{
//        echo "Connected successfully";
	}

?> 