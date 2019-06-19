<?php


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
	 
	$sql = "select announce from announciation";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    // 输出数据
	    while($row = $result->fetch_assoc()) {
	        echo $row["announce"];
	    }
	}
	$conn->close();
?>