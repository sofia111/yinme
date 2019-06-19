<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>操作平台</title>
</head>
<link rel="stylesheet" type="text/css" href="css/friendLink.css">
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
                <li><a href="index.php">首页</a></li>
                <li><a href="manager.php">上一页</a></li>
                <li><button>注销</button></li>
            </ul>
		</div>
	</div>
	<div id="friend">
	    <form action="" method="post">
	    	    	
	    	<span>网站名:</span><input class="text" type="text" name="webname" ><br>
	        <span>网&nbsp&nbsp&nbsp址:</span><input class="text" type="text" name="website"></br></br></br>
		        <input type="submit" name="addWebsite" value="添加">
		        <input type="submit" name="cancelWebsite" value="删除">

	    </form>
	    <?php 
	        $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
				    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
				    mysqli_query($link,"set names utf8"); 

		    if (isset($_POST['addWebsite'])) {

                $webname=trim($_POST['webname']);
                $website=trim($_POST['website']);

                $sql="select website from t_friend where website='$website'";
                $r=mysqli_query($link,$sql);

                if ($row=mysqli_fetch_array($r)) {
                	echo '<script type="text/javascript">
				               alert("此网址已存在，请重新输入!");
				               var oTxt=document.getElementByclassname("text");
            	               oTxt.value="";
				               </script>';
                }

                else{
                	$sql="insert into t_friend values('','$webname','$website',now())";

                	if (mysqli_query($link,$sql)) {

                		echo '<script type="text/javascript">
					               alert("添加成功!");
					               var oTxt=document.getElementByclassname("text");
	            	               oTxt.value="";
					               </script>';
                	}
                }
		    }
		    if (isset($_POST['cancelWebsite'])) {

		    	$webname=trim($_POST['webname']);
                $website=trim($_POST['website']);
                
                $r=mysqli_query($link,"select * from t_friend where webname='$webname'");
                
                if ($row=mysqli_fetch_array($r)) {
                    mysqli_query($link,"delete from t_friend where webname='$webname'");
                	echo '<script type="text/javascript">alert("删除成功！");
			    		     var oTxt=document.getElementByclassname("text");
            	             oTxt.value="";</script>';
                }
                else
                {
                	echo '<script type="text/javascript">alert("无此网站名，请重新输入");
			    		     var oTxt=document.getElementByclassname("text");
            	             oTxt.value="";</script>';
                }
            }
	    ?>
	</div>  
</body>
</html>