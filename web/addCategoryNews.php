<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>操作平台</title>
</head>
<link rel="stylesheet" type="text/css" href="css/addCategoryNews.css">
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
    <div id="addCategory">
    	<form  method="post" >
	        <span>新闻类别名:</span><input id="text" type="text" name="catname" >
	        <input type="submit" name="addCategory" value="添加">
	        <input type="submit" name="cancelCategory" value="删除"></br>

            <?php 
			    $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
				    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
				    mysqli_query($link,"set names utf8");
                 
			    if (isset($_POST['addCategory'])) {
                    $Catname=trim($_POST['catname']);
		    	    
		    	    $sql="select catname from t_category where catname='$Catname'";
                    $r1=mysqli_query($link,$sql);
                    
                    if ($row1=mysqli_fetch_array($r1)) {

                    	echo '<script type="text/javascript">
				               alert("此类已有，请重新输入!");
				               var oTxt=document.getElementById("text");
            	               oTxt.value="";
				               </script>';
                    }
                    else{
                        $sql2="insert into t_category values('','$Catname',now())";
                        if ($r2=mysqli_query($link,$sql2)) {
				            echo '<script type="text/javascript">
					               alert("添加成功!");
					               var oTxt=document.getElementById("text");
	            	               oTxt.value="";
					               </script>';
					    }
					} 
					
			    }			    
			    if (isset($_POST['cancelCategory'])) {
                     $Catname=trim($_POST['catname']);
			    	$r=mysqli_query($link,"select * from t_category where catname='$Catname'");

			    	if ($rows=mysqli_fetch_array($r)) {
			    		mysqli_query($link,"delete from t_category where catname='$Catname'");
			    		echo '<script type="text/javascript">alert("删除成功！");
			    		     var oTxt=document.getElementById("text");
            	             oTxt.value="";</script>';
			    	}
			    	else{
			    		echo '<script type="text/javascript">alert("无此类新闻，请重新输入");
			    		     var oTxt=document.getElementById("text");
            	             oTxt.value="";</script>';
			    	}
			    }
            ?>

	        <span>新闻分类:</span>
	        <input type="submit" name="queryCategory" value="查询"></br></br>

	        <table border="1" cellpadding="0" width="370px " >
	        	<thead>
			        	<tr>
			        		<th id="id">序号</th>
			        		<th id="cate">新闻类别</th>
			        	</tr>
			        </thead>
			        <tbody>
	        		<?php 
                        if (isset($_POST['queryCategory'])) {
					    	$sql=mysqli_query($link,"select * from t_category");
					    	$info=mysqli_fetch_array($sql);
					    	if ($info==false) {
					    		echo '<script type="text/javascript">
						               alert("暂时无新闻类别!");
						               var oTxt=document.getElementById("text");
            	                       oTxt.value="";
						               </script>';
					    	}
					    	$sql=mysqli_query($link,"select * from t_category");
					    	while($info=mysqli_fetch_array($sql))
					    	{
					    		echo '
					    		<tr> 
					                <td align="center">'.$info['catID'].'</td>
					                <td align="center">'.$info['catname'].'</td>
					                
					            </tr>
					            ';
					    	}
					    }
	        		 ?>
	            </tbody>
	        </table>
        </form>
    </div>
</body>
</html>
 