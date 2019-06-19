<?php
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}

// 初始化返回数据
$data = [
	'status' => 0,
	'msg' => '',
];
$mysql_conn = MySQL::getConn();

// 链接数据库失败
if (!$mysql_conn) {
	$data['msg'] = 'Database connect fail';
	echo json_encode($data);
	exit();
}

// 查询数据库的文件
$query_data = [
	':order_no' => $_POST['order_no'],
];

$sql = "SELECT `is_temp` FROM print
    WHERE `order`=:order_no";

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
if ($result[0]['is_temp'] == 0) {
	$data['status'] = 1;
    $data['msg'] = 'success';
}
echo json_encode($data);
