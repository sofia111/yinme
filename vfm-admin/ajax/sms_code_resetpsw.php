<?php 
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}

if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
if (file_exists('../class.php')) {
	require_once '../class.php';
}
require_once '../users/users.php';
global $_USERS;
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();
require_once '../class.php';
$timeconfig = SetUp::getConfig('default_timezone');
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

if ($_POST['user_email'] && $_POST['newp']&& $_POST['resetsms_code']) {
	$postemail = $_POST['user_email'];
	$newp = $_POST['newp'];
	$resetsms_code = $_POST['resetsms_code'];
	if($postemail) {
   if( !isset($_SESSION["mobile_".$postemail]) || $_SESSION["mobile_".$postemail] != trim($resetsms_code) ){
    echo '<div class="alert alert-warning" role="alert"><strong></strong>手机验证码错误</div>';
       $updater = new Updater();
		$encodeExplorer = new EncodeExplorer();
		$updater->resetpass();
    exit();
  	}else {
   		echo '<div class="alert alert-warning" role="alert"><strong></strong>手机验证成功</div>';
   		$appurl =  SetUp::getConfig('script_url');
	    $activationlink = $appurl."yinme.php";
       /* $salt = SetUp::getConfig('salt');
		$newpass = crypt($salt.urlencode($newp), Utils::randomString());
		$mysql_conn = MySQL::getConn();
		$query_data=[
			':phoneNum' => $_POST['user_email'],
			':password' => $newpass
		];
		$sql = "UPDATE user SET `password` = :password WHERE `phoneNum` = :phoneNum";
		$stmt = $mysql_conn->prepare($sql);
		$stmt->execute($query_data);*/
		$updater = new Updater();
		$encodeExplorer = new EncodeExplorer();
		$updater->resetpass();
		echo '<div class="alert alert-success" role="alert">重置密码成功</div>
		 <script>window.location.href="'.$activationlink.'"</script>'; 
		 $_SUCCESS = $encodeExplorer->getString("重置密码成功，现在可以登陆了");
  		}
	}else{
		echo '';}
	
}
