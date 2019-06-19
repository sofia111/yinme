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
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
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

$postoldname = $post['name'];
$postnewisStudent = $post['isStudent'];
$postschoolName = $post['schoolName'] ? $post['schoolName']: '0';
$postacademyName = $post['academyName'] ? $post['academyName']: '0';
$postmajorName = $post['majorName'] ? $post['majorName']: '0';
$postpass = isset($post['user_new_pass']) ? $post['user_new_pass'] : $post['user_old_pass'];
$salt = SetUp::getConfig('salt');
$postpassword = crypt($salt.urlencode($postpass), Utils::randomString());
$postnewemail = isset($post['user_email']) ? $post['user_email'] : false;
$postemail = isset($post['user_email']) ? $post['user_email'] : $post['user_old_email'];

$sms_code = isset($post['sms_code']) ? $post['sms_code'] : false;

if ($postnewemail) {
   if( !isset($_SESSION["mobile_".$postnewemail]) || $_SESSION["mobile_".$postnewemail] != trim($sms_code) ){
    echo '<div class="alert alert-warning" role="alert"><strong></strong>手机验证码错误</div>';
    exit();
  }else {
    echo '<div class="alert alert-warning" role="alert"><strong></strong>手机验证成功</div>';
  }
}else{
echo '';}
 $resend = false;

//if newemail exist
  if ($postnewemail) {
    $prereguser = $updater->findUserEmailPre($postnewemail);
    // mail exist in pre-reg
    if ($prereguser) {
        $resend = true;
        echo '<div class="alert alert-warning" role="alert"><strong>'.$postnewmail.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
  }

} 

exit();