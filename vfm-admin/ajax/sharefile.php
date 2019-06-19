<?php
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
/**
 * @File:	sharefile.php
 * @Author: Alan_Albert
 * @Email:  1766447919@qq.com
 * @Date:	2018-07-22 16:29:01
 * @Last Modified by:   Alan_Albert
 * @Last Modified time: 2018-07-30 13:00:27
 * @Comment: 分享文件
 */

$link=MySQL::getlink();

if ($_POST['username'] && $_POST['filename'] && $_POST['sharemajor'] && $_POST['shareschool']) {
	$user = $_POST['username'];
	$filename = $_POST['filename'];
	$shareschool = urldecode($_POST['shareschool']);
	$sharemajor = urldecode($_POST['sharemajor']);
   
    $sql = mysqli_query($link,"select page from p_file where user='".$user."' and filename = '".$filename."'");
    $info = mysqli_fetch_array($sql);
	
	if ($info['page'] == -1) {
		echo $info['page'];

	}
	else if ($info['page'] == 0) {
		echo $info['page'];
	}
	else{
		$sql = mysqli_query($link,"update p_file set share='1',school = '".$shareschool."',major = '".$sharemajor."' where user='".$user."' and filename = '".$filename."'");
		echo 1;
    }
}
exit();
