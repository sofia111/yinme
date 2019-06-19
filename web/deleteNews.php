<?php 			    	
    $newsID=$_GET['id'];	
    $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
    mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
    mysqli_query($link,"set names utf8"); 

	$sql="delete from t_news where newsID='$newsID'";
	if ($r=mysqli_query($link,$sql)) {
        echo '<script type="text/javascript">
	          alert("删除成功!");
              </script>';
		/*header("location:checkNews.php");*/
	}
?>
