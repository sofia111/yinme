<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新闻首页</title>
</head>
<script src="js/index.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
<body>
	<div id="container">
		<div id="top">
			<div id="nav">
				<ul id="nav_ul">
					<li class="nav_li"><a href="#">首页</a></li>
					<li class="nav_li"><a href="">新闻分类</a>
                        <ul>
                        	<?php 
                        	    session_start();
	                        	$link=mysqli_connect("localhost","root","") or die("数据库服务器连接失败！<BR>");
	                            mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
	                            mysqli_query($link,"set names utf8");

                                $sql="select catID,catname from t_category";
                                $r=mysqli_query($link,$sql);
                                while($info=mysqli_fetch_array($r)) {
                                	echo '<li><a href="index.php?catID='.$info['catID'].'">'.$info['catname'].'</a></li>';
                                }
                            ?>
                        </ul>
					</li>
					<li class="nav_li"><a href="register.html">用户注册</a></li>
					<li class="nav_li"><a href="backstage.php">后台管理</a></li>
					<li class="nav_li"><a href="#">联系我们</a></li>					
				</ul>
				<form action="queryNews.php" method="post">
					<input class="search_text" type="text" name="search" placeholder="关键字搜索新闻">
					<input class="search_btn" type="submit" name="search_btn" value="搜索">
				</form>
		    </div>
		    <img src="images/12.png">		    
		</div>
		<div id="mid">
            <div id="mid_leftFram">
			    <div id="login" class="mid_bar">
			    	<?php
			    	    echo '
					    <form action="login.php" method="post" name="loginForm">
					    	<h2 class="mid_leftH2">用户/管理员登陆</h2>
					    	<div class="bar_bgColor">'; 		
				    		/*session_start(); */ 
				    		if(!isset($_SESSION['username'])){                       
				    			echo '
						    	<div class="login_txt">
						    	    <span class="login_txt_span">用户名：</span><input class="login_txt_input"type="text" id="userName" name="userName">
						        </div>
				                <div class="login_txt">
						    	    <span class="login_txt_span">&nbsp&nbsp&nbsp密码：</span><input class="login_txt_input" type="password" id="password" name="password">
						    	</div> 
						    	<div class="login_btn" >  
							    	<input class="login_btn_input" type="submit" name="login" value="登陆" >
							    	<input  class="login_btn_input" type="reset" name="reset" value="重置" >
							    </div>'; 
							}                        
				    		else
				    		{
					    		echo '<img src="images/tx.png">
					    	        <div id="logining">
						    	        <p><span id="lab1">用户名：</span>
						    	        <span id="lab2">性别：</span></p>
						    	        <p><span id="name">'.$_SESSION['username'].'</span><span id="sex">'.$_SESSION['sex'].'</span></p>
						    	        <input  type="submit" name="cancelBtn" id="cancel" value="注销" >
					    	        </div>';				    
				      		}
				            echo 
				            '</div> 			    
			            </form>'
			        ?> 
			  
		        </div>
		    <div id="mid_introdoce" class="mid_bar">
		    	<h2 class="mid_leftH2">网站简介</h2>
                <div style="font-size: 16px;text-indent: 2em;">本网站由长沙理工大学计通学院计科四班某某经过不懈努力奋斗于2018年6月13完成</div>
		    </div>
		    <div id="friendLink" class="mid_bar">
		    	<h2 class="mid_leftH2">友情链接</h2>
		    	<ul class="bar_bgColor">
		    		<?php 

                        $sql="select * from t_friend";
                        $r=mysqli_query($link,$sql);

                        while($info=mysqli_fetch_array($r)) {                       
                        	echo '<li><a href="'.$info['website'].'">'.$info['webname'].'</a></li>';
                        	
                        }
		    		 ?>	    			    		
		    	</ul>
		    </div>
		    </div>
            <div id="mid_right">
            	<div id="schoolNews">
            		<div class="mid_rightTitle">
            			 <?php 
            			    if (!isset($_GET['catID'])) {
            			    	$catname="校园新闻";
            				    $sql="select catname from t_category where catname='$catname'";
            			    }
            			    else{
                                $sql="select catname from t_category where catID=".$_GET['catID'];
            			    }
                            $r=mysqli_query($link,$sql);
                            if ($info=mysqli_fetch_array($r)) {
                            	echo $info['catname'];
                            }
            			 ?> 
            			<span >更多&gt&gt</span></div>
            		<div class="newsList">
            			<img src="images/news.jpg">
            			<ul >
            				<?php
            				    if(!isset($_GET['catID']))
            				    {
            				    	$catname="校园新闻";
            				        $sql="select catID from t_category where catname='$catname'";
            				        $r=mysqli_query($link,$sql);
            				        $info=mysqli_fetch_array($r);
            				        $catID=$info['catID'];
            				        $sql="select * from t_news where catID='$catID' order by newstime desc";       				   
            				    }
            				    else{
            				    	$sql="select * from t_news where catID=".$_GET['catID']." order by newstime desc";
            				    }                        
		                        $r=mysqli_query($link,$sql);
                                $i=0;
		                        while($info=mysqli_fetch_array($r)) {                                     
		                            $i++;     
		                            if ($i<6)
		                            {
		                                echo '<li><a href="searchNews.php?id='.$info['newsID'].'">'.$info['title'].'</a><span>'.$info['newstime'].'</span></li>';	
		                            }            	 
		                         }
		    		         ?>	    			  
            			</ul>
            		</div>
            	</div>
             	<div id="notice">
             		<div class="mid_rightTitle">通知公告<span>更多&gt&gt</span></div>
             		<div class="noticeContent">
             			<?php 
                            $sql="select noticetitle,content,noticetime from t_notice order by noticetime desc";
                            $r=mysqli_query($link,$sql);
                                 $i=0;
		                        while($info=mysqli_fetch_array($r)) { 
			                          $i++;     
			                          if ($i<2)
			                          {
		                                echo '<h1  style="text-align: center;">'.$info['noticetitle'].'</h1><div id="nocontent"><p>'.$info['content'].'<p></div><div id="notime">'.$info['noticetime'].'</div>';	
		                               }            	 
		                        }
             			 ?>
             		</div>
             	</div>
            </div>
		</div>
		<div id="footer" class="clr">
			<div id="copyRight">Made&nbspby&nbsp&nbsp计科1604冯海杏&nbsp&nbsp学号201650080405</div>
		</div>
    </div>
</body>
</html>