<?php

	$announce = $_POST['announce'];

	// $link=mysqli_connect("localhost:3306","yinme","SQLKuye5893")or die("数据库服务器连接失败！<BR>");
	// mysqli_select_db($link,"test") or die("数据库选择失败！<BR>");
	// mysqli_set_charset($link,"utf8");
	// $sql = mysqli_query($link,"update announcciation SET announce = '".$announce."'");
	// // $result = mysqli_fetch_row($sql);
	
	// if($sql){
	// 	echo "ok";
	// }else{
	// 	echo mysql_error();
	// }

	$servername = "localhost:3306";
	$username = "yinme";
	$password = "SQLKuye5893";
	$dbname = "test";
	 
	// 创建连接
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 
	 
	$sql = "update announciation SET announce = '".$announce."'";
	$result = $conn->query($sql);
	 
	if ($result) {
	    echo "ok";
	} else {
	    echo $sql;
	}
	$conn->close();
?>