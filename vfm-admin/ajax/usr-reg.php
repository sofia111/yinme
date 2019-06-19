<?php
/**
 * VFM - veno file manager: ajax/usr-reg.php
 *
 * Send email to new pending user
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 * @link      http://filemanager.veno.it/
 */
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}

if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();

require_once '../class.php';

$timeconfig = SetUp::getConfig('default_timezone');
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

require_once '../users/users.php';
global $_USERS;

if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = SetUp::getConfig("lang");
}
require "../translations/".$lang.".php";

if (file_exists('../users/users-new.php')) {
    include '../users/users-new.php';
} else {
    $newusers = array();
}

$encodeExplorer = new EncodeExplorer();
$updater = new Updater();

// $setfrom = SetUp::getConfig('email_from');

// if ($setfrom == null) {
//     echo $encodeExplorer->getString("setup_email_application")."<br>";
//     exit();
// }

$filterType = array(
    'string' => FILTER_SANITIZE_STRING,
    'integer' => FILTER_VALIDATE_INT,
);

$post = array();

foreach ($_POST as $key => $value) {
    $filter = $filterType[gettype($value)];
    $value = filter_var($value, $filter);
    $post[$key] = $value;
}


$postisStudent = isset($post['isStudent']) ? $post['isStudent']:false;
$postschoolName = (($post['schoolName']) != "0") ? $post['schoolName']:'0';
$postacademyName = (($post['academyName']) != "0") ? $post['academyName']:'0';
$postmajorName = (($post['majorName']) != "0") ? $post['majorName']:'0';

$postname =  isset($post['user_email']) ? $post['user_email'] : false;
/*isset($post['user_name']) ? $post['user_name'] : false;*/
$postpass = isset($post['user_pass']) ? $post['user_pass'] : false;
$postpassconfirm = isset($post['user_pass_confirm']) ? $post['user_pass_confirm'] : false;
$postmail = isset($post['user_email']) ? $post['user_email'] : false;
$postcaptcha = isset($post['captcha']) ? $post['captcha'] : false;
$sms_code = isset($post['sms_code']) ? $post['sms_code'] : false;

unset(/*$post['user_name'],*/ $post['user_pass'], $post['user_pass_confirm'], $post['user_email'], $post['captcha']);

$salt = SetUp::getConfig('salt');
$postpassword = crypt($salt.urlencode($postpass), Utils::randomString());

if (!$postisStudent
    || !$postname 
    || !$postmail
    || !$postpass 
    || !$postpassconfirm
    || !$sms_code
) {
    echo '<div class="alert alert-warning" role="alert">'.$encodeExplorer->getString("fill_all_fields").' *</div>';
    exit();
}

$postname = preg_replace('/\s+/', '', $postname);

// minimum username lenght
if (strlen($postname) < 3) {
    echo '<div class="alert alert-danger" role="alert">'.$encodeExplorer->getString("minimum").'3 chars</div>';
    exit();
}

// passwords mismatch
if ($postpass !== $postpassconfirm) {
    echo '<div class="alert alert-danger" role="alert">'.$encodeExplorer->getString("passwords_dont_match").'</div>';
    exit();
}

// username already exists
if ($updater->findUser($postname)) {
    echo '<div class="alert alert-danger" role="alert"><strong>'.$postname.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
    exit();
}

// e-mail already exists
if ($updater->findEmail($postmail)) {
    echo '<div class="alert alert-warning" role="alert"><strong>'.$postmail.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
    exit();
}

//var_dump($_SESSION[$postmail]);
if( !isset($_SESSION["mobile_".$postmail]) || $_SESSION["mobile_".$postmail] != trim($sms_code) ){
    echo '<div class="alert alert-warning" role="alert"><strong></strong>手机验证码错误</div>';
    exit();
}

// check capcha
if (Utils::checkCaptcha($postcaptcha, 'show_captcha_register') !== true) {
    echo '<div class="alert alert-warning" role="alert">'.$encodeExplorer->getString("wrong_captcha").'</div>';
    exit();
}
// if is already on pre-registration 
// send again an activation link
$resend = false;
$prereguser = $updater->findUserEmailPre($postmail);

// mail exist in pre-reg
if ($prereguser) {
    $resend = true;
    // username is different from the first associated to this e-mail
    // resend activation mail with first username chosen
    echo '<div class="alert alert-warning" role="alert"><strong>'.$postmail.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
    if ($prereguser !== $postname) {
        $postname = $prereguser;
    }
} else {
    // e-mail has never been used, check if username is alredy pre-registered 
    if ($updater->findUserPre($postname)) {
        echo '<div class="alert alert-warning" role="alert"><strong>'.$postname.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
        exit();
    }
}

$lifetime = strtotime("-1 day");
$newusers = $updater->removeOldReg($newusers, 'date', $lifetime);

$newuser = array();
$newuser['isStudent'] = $postisStudent;

$newuser['name'] = $postname;
$salt = SetUp::getConfig('salt');
$newuser['pass'] = crypt($salt.urlencode($postpass), Utils::randomString());
$newuser['email'] = $postmail;

foreach ($post as $custom => $value) {
    $newuser[$custom] = $value;
}

$date = date("Y-m-d", time());
$newuser['date'] = $date;

$activekey = md5($postname.$salt.$date);
$newuser['key'] = $activekey;

$appurl =  SetUp::getConfig('script_url');
$activationlink = $appurl."yinme.php?act=".$activekey;

if (!$resend) {
    array_push($newusers, $newuser);
	
}

if ($updater->updateRegistrationFile($newusers, "../users/")) {
  $mysql_conn=MySQL::getConn();
    $query_data = [
        ':userName' =>$postname,
        ':isStudent' =>$postisStudent,
        ':schoolName' =>$postschoolName,
        ':academyName' =>$postacademyName,
        ':majorName' =>$postmajorName,
        ':phoneNum' =>$postmail,
        ':password' =>$postpassword,
        ':credit' => 0,
        ':invitation' => 0,
		':addre' =>'',
		':orders' =>'0',
		':pages' =>'0',
        ':isfirstorder' =>'1',
        ':sharenumbers' => '0'
    ];

    $sql = 'INSERT INTO user VALUES(
        null, 
        :userName,
        :isStudent,
        :schoolName,
        :academyName,
        :majorName,
        :phoneNum,
        :password,
        :credit,
        :invitation,
		:addre,
		:orders,
		:pages,
        :isfirstorder,
        :sharenumbers
    )';
    $stmt = $mysql_conn->prepare($sql);
    $stmt->execute($query_data);
    //邀请
    $invited = isset($post['user_invited']) ? $post['user_invited'] : false;
     $query_data = [
        ':invitation' => $invited
    ];
    $sql = "UPDATE user SET invitation = invitation + 1 WHERE phoneNum = :invitation";
    $stmt = $mysql_conn->prepare($sql);
    $stmt->execute($query_data);
   
         echo '<div class="alert alert-success" role="alert">注册成功</div>
		 
		 <script>window.location.href="'.$activationlink.'"</script>';  
    } else {
        echo '<div class="alert alert-danger" role="alert"><strong>users-new</strong> file update failed</div>';
    }

exit;
