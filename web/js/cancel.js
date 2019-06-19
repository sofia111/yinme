window.onload=function () {
		var oBtn=document.getElementsByTagName('button');
		oBtn.onclick=function() {
			$_SESSION['username']=null;
			header("location:index.php");
		}
	}