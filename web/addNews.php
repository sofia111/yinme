<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>操作平台</title>
</head>
<link rel="stylesheet" type="text/css" href="css/news.css">
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
		<div id="news">
			<span>新闻类别:</span><input class="text" type="text" name="catname">
			<select id="select" name="select">
	            <option>-选择新闻类型-</option>
	            <?php 
	                 $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
					    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
					    mysqli_query($link,"set names utf8");

					    $sql=mysqli_query($link,"select catname from t_category");

					    while($info=mysqli_fetch_array($sql))
						    	{
						    		echo '<option>'.$info['catname'].'</option>';
						    	}
	             ?>
	        </select><br>
	        <span>新闻标题:</span><input class="text"  type="text" name="title"><br>
	        <span >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp作者:</span><input  class="text" type="text" name="author"><br>
	        <span>新闻内容:</span><input style="margin-left: 240px;" type="submit" name="addNews" value="添加"><br>
	        <textarea cols="40" rows="15" name="content"></textarea>
        </form> 
        <?php 
        
            if (isset($_POST['addNews'])) {
            	$catname=trim($_POST['catname']);
            	$title=trim($_POST['title']);
            	$author=trim($_POST['author']);
            	
          	    $pattern = array('/ /','/　/','/\r\n/','/\n/');
          	    $replace = array('&nbsp;','&nbsp;','<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;','<br />');
          	    $content = preg_replace($pattern, $replace, $_POST['content']);
          	    //获取catID
            	$r=mysqli_query($link,"select catID from t_category where catname='$catname'");
            	$row=mysqli_fetch_array($r);
            	$catID=$row['catID'];
                
                //获取userID
            	$r1=mysqli_query($link,"select * from t_user where Username='$author'");
            	$row1=mysqli_fetch_array($r1);
            	$operator=$row1['userID'];
                
                //插入数据
                $sql="insert into t_news values('','$catID','$title','$content',now(),'$operator')";
            	if ($r2=mysqli_query($link,$sql)) {
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
	</div>
</body>
</html>
<script type="text/javascript">
	window.onload=function () {
		var catname=document.getElementsByTagName('input')[1];
		var select=document.getElementById('select');
		select.onchange=function () {
			catname.value=select.value;
		}
    }  	
</script>