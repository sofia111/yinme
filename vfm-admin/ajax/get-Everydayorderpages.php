<?php  
/**
 * @File:	get-Everydayorderpages.php
 * @Author: Sofia
 * @Email:  1506798421@qq.com
 * @Date:	2018-08-27 16:30:33
 * @Comment: 查询每天订单优惠页数文件
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
/*$data['arr'] =json_decode($_POST['arr'],true);
$data['len'] = sizeof($data['arr']);
$data['1'] = $data['arr'][0]['thisfile'];
*/

// 链接数据库失败
if (!$mysql_conn) {
	$data['msg'] = 'Database connect fail';
	echo json_encode($data);
	exit();
}


$query_data =[
	':username' => $_SESSION['vfm_user_name']
];
$sql = "SELECT `orders`,`pages`,`isfirstorder` FROM user WHERE `userName` = :username";

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

// var_dump($result);

// 组织查询结果并返回
$data['status'] = 1;
$data['msg'] = 'success';
$data['orders'] = empty($result) ? -1 : $result[0]['orders'];
$data['pages'] = empty($result) ? -1 : $result[0]['pages'];
$data['isfirstorder'] = empty($result)? -1: $result[0]['isfirstorder'];

echo json_encode($data);



