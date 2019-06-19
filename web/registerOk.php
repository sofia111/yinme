<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>注册成功</title>

</head>
<body onload="countTime();">
<script type="text/javascript">
	var x=10;
	function countTime(){		
		if (x>=0) {
			document.getElementById('count').innerHTML=x+'s';
			x--;
		}
		else{
			window.location.href="index.php";
		}
	}
	window.setInterval('countTime()',1000);
</script>
<?php
    header("Content-type: text/html; charset=utf-8"); 
    $username=trim($_POST['userName']);
    $phonenum=trim($_POST['phoneNum']);
    $sex=trim($_POST['sex']);
    $userpassword=trim($_POST['userPassword']);


    $link=mysqli_connect("localhost","root","") or die("数据库服务器连接失败！<BR>");
    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
    mysqli_query($link,"set names utf8");
    $sql="select Username from t_user where Username='$username'";
    $result=mysqli_query($link,$sql);
    $row = mysqli_fetch_array($result);
    
    if ($row) {
     	echo '<div style="text-align: center;font-size: 40px;">此用户名已经存在！请重新注册！</div>
     	<p style="size: 20px;text-align: center;"><a href="register.html">返回注册页面</a></p>
     	     ';
    	die();
    }
    $sql="insert into t_user(userID,Username,Password,Sex,PhoneNum,regtime,Role)";
    $sql=$sql."values('','$username','$userpassword','$sex','$phonenum',now(),'1')";
    
    if (mysqli_query($link,$sql)) {
        
    	echo '<div style="text-align: center;font-size: 40px;">注册成功!</div>
        <div style="text-align: center;margin-top: 20px;">倒计时10s后跳转首页</div>
        <div style="text-align: center;margin-top: 20px;font-size: 18px; color: red;" id="count" >10s</div>';
    }
    else{
    	echo '<p>注册失败</p>';
    }      
 ?>
</body>
</html>
