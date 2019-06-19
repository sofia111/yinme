<?php 

if (file_exists('include/mysql/MySQL.class.php')) {
	    require 'include/mysql/MySQL.class.php';
	}
	$mysql_conn=MySQL::getlink();


	
	$sql = "insert into suggestion values('".$_POST['suggestion']."')";
	$result = $mysql_conn->query($sql);

 ?>