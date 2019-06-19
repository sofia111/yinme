<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>后台</title>
</head>
<body>
	<?php 
	    header("Content-Type: text/html;charset=utf8");
	    session_start();
        if (!isset($_SESSION['username'])) {
     	   echo '<script type="text/javascript">
	                alert("请先登陆！用户名：sofia 密码：123123");
                 </script>
                 <div><a href="index.php">首页</a></div>';
        }
        else{
        	if (($_SESSION['username']=='sofia') && $_SESSION['password']=='123123') {
        		header("location:manager.php");
            }
	        else{
	     	    echo '<script type="text/javascript">
		                alert("非管理员不可操作");
	                 </script>
	                 <div><a href="index.php">首页</a></div>';
	            }
        }
        
	?>	  

</body>
</html>