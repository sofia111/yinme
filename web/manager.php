<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>操作平台</title>	
</head>
<link rel="stylesheet" type="text/css" href="css/manage.css">	
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
<div id="operation">
		<h3 class="list_head">功能菜单</h3>
		<ul>
			<li class="list"><a href="">系统用户管理</a></li>
			<li class="list"><a href="addCategoryNews.php">新闻类别管理</a></li>
			<li class="list"><a href="addNews.php">新闻添加</a></li>
			<li class="list"><a href="checkNews.php">新闻查询</a></li>
			<li class="list"><a href="">留言管理</a></li>
			<li class="list"><a href="friendLink.php">友情链接</a></li>
			<li class="list"><a href="notice.php">系统公告管理</a></li>
		</ul>
	</div>	
</body>
</html>
	