<?php  
/**
 * @File:   get-user_email.php
 * @Author: sofia
 * @Email:  1506798421@qq.com
 * @Date:   2018-09-30 12:53:20
 * @Last Modified by:   sofia
 * @Last Modified time: 2018-07-30 11:06:21
 * @Comment: 从数据库获取注册用户的手机号
 */

// 初始化返回数据
$data = [
	'status' => 0,
	'msg' => '',
	'phoneNum' => 0
];
// 缺少查询参数
if (!isset($_POST['user_email'])) {
	$data['msg'] = 'Request parameter miss';
	echo json_encode($data);
	exit();
}

//包含数据文件
if (!defined('SQL_INC')&&file_exists('../include/mysql/MySQl.class.php')) {
	require'../include/mysql/MySQL.class.php';
}

$mysql_conne = MySQL::getConn();

//连接数据库失败
if (!$mysql_conne) {

 	$data['msg']='Database connect fail';
 	echo json_decode($data);
 	exit();
 } 

//查询数据库文件
$query_data=[
	':phoneNum' => $_POST['user_email']
];

$sql="SELECT `phoneNum` FROM user WHERE `phoneNum`=:phoneNum";

try{
	//查询数据库
	$stmt = $mysql_conne->prepare($sql);
	$stmt->execute($query_data);
	$result = $stmt->fetchAll();

}catch(PDOException $e){
	//查询数据库出错
    $data['msg']='Query data fail:'.$e->getMessage();
    echo json_decode($data);
    exit();
}

$data['status'] = 1;
$data['msg'] = 'success';
$data['phoneNum'] = empty($result) ? -1 : $result[0]['phoneNum'];
echo json_encode($data);