 <?php 

    header("Content-Type: text/html;charset=utf8");
    session_start();
    $link=mysqli_connect("localhost","root","")or die("数据库服务器连接失败！<BR>");
	mysqli_select_db($link,"yynews") or die("数据库选择失败！<BR>");
	mysqli_query($link,"set names utf8"); 		    	    
    if (isset($_GET['addcomment'])) {
	                 
			      	
	    if (isset($_SESSION['username'])) {
	    
			    $username=$_SESSION['username'];
			    $nid=$_GET['id'];
			    $c=$_GET['content'];
		    $sql="select userID from t_user where Username='$username'";
		    $result=mysqli_query($link,$sql);
		    $info=mysqli_fetch_array($result);
		    $userID=$info['userID'];
	       
	        $sql="insert t_comment values('','$userID','$nid',now(),'$c')";
	        if(mysqli_query($link,$sql)) {

	       	   header("location:searchNews.php?id=$nid");
	        }
	 	}
	}

?>
