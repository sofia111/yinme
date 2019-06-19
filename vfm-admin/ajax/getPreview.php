<?php
// 初始化返回数据
$data = [
	'status' => 0,
	'msg' => '',
	'preview' => 0
];

// 缺少查询参数
if (!isset($_POST['username']) || !isset($_POST['filename'])) {
	$data['msg'] = 'Request parameter miss';
	echo json_encode($data);
	exit();
}

// 引入MySQL数据库连接文件
if (!defined('SQL_INC') && 
	file_exists('../include/mysql/MySQL.class.php'))
	require '../include/mysql/MySQL.class.php';

$mysql_conn = MySQL::getConn();

// 链接数据库失败
if (!$mysql_conn) {
	$data['msg'] = 'Database connect fail';
	echo json_encode($data);
	exit();
}

// 查询数据库的文件
$query_data = [
	':username' => $_POST['username'],
	':filename' => urldecode($_POST['filename'])
];

$sql = "SELECT `preview` FROM p_file 
    WHERE `user`=:username AND `filename`=:filename";

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

if (empty($result)) {
	$data['status'] = 1;
	$data['msg'] = 'have no data';
	$data['preview'] = '';
	echo json_encode($data);
	exit();
}

// 组织查询结果并返回
$data['status'] = 1;
$data['msg'] = 'success';
$data['preview'] = $result[0]['preview'];
echo json_encode($data);
