<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新闻查看</title>
</head>
<script src="cancel.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/searchNews.css">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<body>
	<div id="body">
	<div id="head">
		<ul id="head_left">
			<li>
				<?php header("Content-Type: text/html;charset=utf8");
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
                     	echo '<li><input  type="submit" name="cancelBtn" value="注销"></li>	';
                     }
	    	    ?>
    	    </form>
         </ul>	
	</div>
	<div id="news">
		<?php 

		    $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
			mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
			mysqli_query($link,"set names utf8"); 
            
			$sql="select * from t_news where newsID=".$_GET['id'];

			$r=mysqli_query($link,$sql);

			if ($info=mysqli_fetch_array($r)) {
                
                $result=mysqli_query($link,"select Username from t_user where userID=".$info['operator']);
                $Username=mysqli_fetch_array($result);
               
				echo '<h1>'.$info['title'].'</h1>
				      <h3>作者：'.$Username['Username'].'</h3>
	                  <div class="clr" id="content">'.$info['content'].'</div>
	                  <h3>'.$info['newstime'].'</h3><br><br>';
			}		    
        ?>
	</div>
	<h2 >Write Comments</h2>
	<div id="comment" class="clr">
		 <?php
		     echo '<form action="addComment.php">
                <input type="hidden" name="id" value='.$_GET['id'].'>	     
	    	     <textarea cols="96" rows="2" name="content"></textarea><br>
	    	     <input type="submit" name="addcomment" value="提交评论">	
	    	      ';
                if (!isset($_SESSION['username'])) {
                	echo '<script type="text/javascript">
	                  var add=document.getElementsByTagName("input")[1];
						add.onclick=function () {
							alert("请先登陆！");
							return false;
						}
					</script>';
                }
	            ?>
    	 </form>
    </div>
    <h2 class="clr">Comments</h2>
    <div class="clr" id="commentArea">  	
    	<ul>
    		<?php 
                $sql="select * from t_comment where newsID=".$_GET['id'];
               if ( $r=mysqli_query($link,$sql)) {
                	while ($info=mysqli_fetch_array($r)) {
                	echo '<li>
	                    	 <div id="userID">用户ID：'.$info['userID'].'<span>'.$info['commtime'].'</span>
	                    	 </div>
                             <div id="content">'.$info['content'].'</div>
	                      </li>' ;
                    }
                }

    	    ?>
    	</ul>
    </div>
	</div>	
</body>
</html>

