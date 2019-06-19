<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>操作平台</title>
</head>
<link rel="stylesheet" type="text/css" href="css/notice.css">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/manageHead.css">
<body style="background: url(images/operation.jpg);">
	<div id="head">
		<h2>新闻后台管理</h2>
		<div class="head_list">
			<ul class="head_left">
				<li>欢迎您：<span>sofia</span></li>
				<li>角色：管理员</li>				
			</ul>
			<ul class="head_right">	
                <form action="login.php" method="post">
	                <li><a href="index.php">首页</a></li>
	                <li><a href="manager.php">上一页</a></li>
	                <?php 
	                   session_start();
                    if (isset($_SESSION['username'])) {
                     	echo '<li><input  type="submit" name="cancelBtn" value="注销"></li>	';
                     }
	    	    ?>
    	        </form>
            </ul>
		</div>
	</div>
	<form method="post">
		<div id="notice">
			<span>系统公告：</span>
			<input  type="submit" name="addNotice" value="添加"><br><br>
			<span id="title">公告标题：</span><input type="text" name="noticetitle"><br><br>
	        <textarea cols="30" rows="10" name="content" id="content"></textarea>
		</div>
		<?php 
             $link=mysqli_connect("localhost","root","") or die("数据库服务器连接失败！<BR>");
             mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
             mysqli_query($link,"set names utf8");

             if (!isset($_POST['addNotice'])) {
             	echo "非法登陆";
             }
             else{
             	
                $pattern = array('/ /','/　/','/\r\n/','/\n/');
          	    $replace = array('&nbsp;','&nbsp;','<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;','<br />');
          	    $content = preg_replace($pattern, $replace, $_POST['content']);

          	    $noticetitle = trim($_POST['noticetitle']);

             	$sql="insert into t_notice values('','$noticetitle','$content',now())";
             	if ($r=mysqli_query($link,$sql)) {
            		echo '<script type="text/javascript">
					        alert("添加成功!");			           
					        </script>';
             	}
             	else{
             		echo '<script type="text/javascript">
					        alert("添加失败!");			           
					        </script>';
             	}
             }
		 ?>
    </form>
</body>
</html>