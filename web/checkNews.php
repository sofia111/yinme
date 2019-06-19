<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>查询新闻</title>
</head>
<link rel="stylesheet" type="text/css" href="css/checkNews.css">
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
	<div id="checkNews">
		<form>
			<input class="search_text" type="text" name="search" placeholder="关键字搜索新闻">
			<input class="search_btn" type="submit" name="search_btn" value="搜索">		
	        <ul>

	    		<?php 
	                
	                if (isset($_GET['search_btn'])) {
	                
		                $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
					    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
					    mysqli_query($link,"set names utf8"); 
		                
		                $title=trim($_GET['search']);

					    $sql="select * from t_news where title like '%$title%' order by newstime desc";
					    $r=mysqli_query($link,$sql);
					    $i=0;
					    while($info=mysqli_fetch_array($r)) {
					    	$i++;
					    	echo '<li><a id="newsLink" href="searchNews.php?id='.$info['newsID'].'">'.$info['title'].'</a><span>'.$info['newstime'].'</span><a class="deleteLink" href="deleteNews.php?id='.$info['newsID'].'">删除</a></li>';
					    }					              
					    if ($i=='0') {
					    	echo '<div>没有您搜索的新闻！</div>';
					    }
					 
				    }		   

	    		 ?>
		    </ul>
	    </form>
	</div>
</body>
</html>
<script type="text/javascript">
    var del=document.getElementsByClassName('deleteLink');
    for (var i = 0; i < del.length; i++) {
    	del[i].onclick=function () {
	    	if (confirm("确认删除吗？")) {
	    		return true;
	    	}
	    	else{
	    		return false;
	    	}
        }
    }
</script>
