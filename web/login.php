<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>登陆</title>
</head>
<body>
<?php
    header("Content-Type: text/html;charset=utf8");
    session_start();
    if (!isset($_POST['login']) && !isset($_POST['cancelBtn'])) {
    	exit('非法访问');
    }
    
    if (isset($_POST['login'])) {
    	    		
	    $username=$_POST['userName'];
	    $password=$_POST['password'];

	    $link=mysqli_connect("localhost","root","") or die("数据库服务器连接失败！<BR>");
	    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
	    mysqli_query($link,"set names utf8");

	    
	    $r=mysqli_query($link,"select * from t_user where Username='$username' and Password='$password'");
	    
	    if($rows=mysqli_fetch_array($r)) {
	    	echo '<div style="text-align: center;font-size: 40px;">登陆成功!</div>';
	    	//登陆成功
	    	$_SESSION['password']=$rows['Password'];
	    	$_SESSION['userID']=$rows['userID'];
	    	$_SESSION['sex']=$rows['Sex'];
	    	$_SESSION['username']=$rows['Username'];
	    	$role=$rows['Role'];
	    	if ($role=='1') {
	    		header("location:index.php");
	    	}
	    	if ($role=='0') {
	    		header("location:manager.php");
	    	}
	    	
	    }
	    else{
	    	echo '<p>登陆失败,账号或密码错误</p>';
	    }  
	}
	else
		if (isset($_POST['cancelBtn'])) {
			$_SESSION['password']=null;
			$_SESSION['username']=null;
			header("location:index.php");
		}
?> 

</body>
</html>