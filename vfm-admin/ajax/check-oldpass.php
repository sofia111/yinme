<?php  
 require '../class.php';
 require '../config.php';

 $oldpass = $_POST['oldpass'];
 $oldp = $_POST['oldp'];
 $salt = SetUp::getConfig('salt');
 // $postpassword = crypt($salt.urlencode($oldp), Utils::randomString());
 $passo = $salt.urlencode($oldp);
if (crypt($passo, $oldpass) == $oldpass) {
    echo 1;
}else{
	echo 0;
}

/*echo json_encode($data);*/
