<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>查询新闻</title>
</head>

<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/queryNews.css">
<body>
	<div id="body">
		<div id="head">
			<ul id="head_left">
				<li>
					<?php 
					    header("Content-Type: text/html;charset=utf8");
					    session_start();
                        if (!isset($_SESSION['username'])) {
                     	   echo "<span>请返回首页登陆</span>";
                        }
                        else{
                     	   echo '欢迎您：<span>'.$_SESSION['username'].'</span>';
                        }
				    ?>	    	
			    </li>
			</ul>
			<ul id="head_right">
				<form action="login.php" method="post">
		    	    <li><a href="index.php">首页</a></li>
		    	    <?php 
	                    if (isset($_SESSION['username'])) {
	                     	echo '<li><input type="submit" name="cancelBtn" value="注销"></li>	';
	                     }
		    	    ?>
	    	    </form>
            </ul>	
		</div>
	    <div id="queriedNews">
	    	<ul>
	    		<?php 
	                
                    if (isset($_POST['search'])) {
                    
		                $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
					    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
					    mysqli_query($link,"set names utf8"); 
		                
		                $title=$_POST['search'];

					    $sql="select * from t_news where title like '%$title%' order by newstime desc";
					    $r=mysqli_query($link,$sql);
					    $i=0;
					    while($info=mysqli_fetch_array($r)) {
					    	$i++;
					    	echo '<li><a href="searchNews.php?id='.$info['newsID'].'">'.$info['title'].'</a><span>'.$info['newstime'].'</span></li>';
					    }
					    if ($i=='0') {
					    	echo '<div>没有您搜索的新闻！</div>';
					    }
					 
				    }
				   
	    		 ?>
	    	</ul>

	    </div>
	</div>
</body>
</html>
