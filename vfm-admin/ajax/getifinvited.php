<?php  
/**
 * @File:	getifinvited.php
 * @Author: Sofia
 * @Email:  1506798421@qq.com
 * @Date:	2018-10-25 20:30:33
 * @Comment: 查询是否邀请好友文件
 */

if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}//连接数据库
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();
// 初始化返回数据
$data = [
	'status' => 0,
	'msg' => ''
];


$mysql_conn = MySQL::getConn();

// 链接数据库失败
if (!$mysql_conn) {
	$data['msg'] = 'Database connect fail';
	echo json_encode($data);
	exit();
}


$query_data =[
	':username' => $_SESSION['vfm_user_name']
];
$sql = "SELECT `sharenumbers` FROM user WHERE `userName` = :username";

try {	
	// 查询数据
	$stmt = $mysql_conn->prepare($sql);
	$stmt->execute($query_data);
	$result = $stmt->fetchAll();
} catch (PDOException $e) {
	// 查询数据库出错
	$data['msg'] = 'Query database fail: ' . $e->getMessage();
	echo json_encode($data);
	exit();
}
$data['issharenumbers'] = $result[0]['sharenumbers'];
$data['sharenumbers']  =$_SESSION['invitationnumbers'];
// 组织查询结果并返回
if ($result[0]['sharenumbers']>$_SESSION['invitationnumbers']) {
	
	$_SESSION['isinvited']  = 1;
	$data['status'] = 1;
    $data['msg'] = 'success';

}
echo json_encode($data);


