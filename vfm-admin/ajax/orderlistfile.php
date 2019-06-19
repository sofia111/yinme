<?php 

if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';

}
/**
 * @File:	orderlistfile.php
 * @Author: Sofia
 * @Email:  1506798421@qq.com
 * @Date:	2018-08-22 16:30:33
 * @Comment: 后台管理查询订单文件
 */

/*
链接数据库
*/
$mysql_conn=MySQL::getConn();
$data=[
	'status' =>0
];
if (isset($_POST['seaschool']) && isset($_POST['seashop']) && isset($_POST['starttime']) && isset($_POST['endtime'])) {
	
	$seaschool = urldecode($_POST['seaschool']);
	$seashop = urldecode($_POST['seashop']);
	$starttime = urldecode($_POST['starttime']);
	$endtime = urldecode($_POST['endtime']);
	$query_data = [
       ':seaschool' => $seaschool,
       ':seashop' => $seashop,
       ':starttime' => $starttime,
       ':endtime' => $endtime,
       ':is_temp' => '0';
		];
	if ($starttime == $endtime) {
       
		if ($seaschool == '0' && $seashop =='0') {
			unset($query_data[':seaschool'],$query_data[':seashop'],$query_data[':endtime']);
			$sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
			WHERE Date(`time`)=:starttime AND `is_temp` =:is_temp ORDER BY `time` DESC";
			}
		elseif($seaschool != '0' && $seashop !='0'){
			unset($query_data[':endtime']);

				$sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
				WHERE Date(`time`)=:starttime AND `school`=:seaschool AND `shop` =:seashop AND `is_temp` =:is_temp ORDER BY `time` DESC";
			}
		elseif ($seaschool == '0' && $seashop !='0') {
			unset($query_data[':seaschool'],$query_data[':endtime']);
               $sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
				WHERE Date(`time`)=:starttime AND `is_temp` =:is_temp AND  `shop` =:seashop ORDER BY `time` DESC";				
			}
		elseif ($seaschool != '0' && $seashop =='0') {
			unset($query_data[':seashop'],$query_data[':endtime']);
			$sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
				WHERE Date(`time`)=:starttime AND `is_temp` =:is_temp AND  `school` =:seaschool ORDER BY `time` DESC";
		}
		$stmt = $mysql_conn->prepare($sql);
		$stmt->execute($query_data);
		 $res_arr = $stmt->fetchAll();
	}elseif ($starttime != $endtime) {
		$query_data = [
       ':seaschool' => $seaschool,
       ':seashop' => $seashop,
       ':starttime' => $starttime,
       ':endtime' => $endtime
	];
		if ($seaschool == '0' && $seashop =='0') {
			unset($query_data[':seaschool'],$query_data[':seashop']);
			$sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
			WHERE Date(`time`)>=:starttime AND `is_temp` =:is_temp AND Date(`time`)<=:endtime ORDER BY `time` DESC";
			}
		elseif($seaschool != '0' && $seashop !='0'){

				$sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
				WHERE Date(`time`)>=:starttime AND Date(`time`)<=:starttime AND `school`=:seaschool AND `is_temp` =:is_temp AND `shop` =:seashop ORDER BY `time` DESC";
			}
		elseif ($seaschool == '0' && $seashop !='0') {
			unset($query_data[':seaschool']);
               $sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
				WHERE Date(`time`)>=:starttime AND `is_temp` =:is_temp AND Date(`time`)<=:endtime AND `shop` =:seashop ORDER BY `time` DESC";
				
			}
		elseif ($seaschool != '0' && $seashop =='0') {
			unset($query_data[':seashop']);
			$sql = "SELECT `order`,`filename`,`shop`,`school`,`price`,`free_delivery`,`discount`,`yinbi`,Date(`time`) FROM print 
				WHERE Date(`time`)>=:starttime AND `is_temp` =:is_temp AND Date(`time`)<=:endtime AND `school` =:seaschool ORDER BY `time` DESC";
		}
		$stmt = $mysql_conn->prepare($sql);
		$stmt->execute($query_data);
		$res_arr = $stmt->fetchAll();
		var_dump($res_arr);
		die();
	}
	if (count($res_arr) !='0') {
		foreach ($res_arr as $key => $value) {
			$data['data'][$key]['order'] = $value[0];
			$data['data'][$key]['filename'] = $value[1];
			$data['data'][$key]['shop'] = $value[2];
			$data['data'][$key]['school'] = $value[3];
			$data['data'][$key]['price'] = $value[4];
			$data['data'][$key]['free_delivery'] = $value[5];
			$data['data'][$key]['discount'] = $value[6];
			$data['data'][$key]['yinbi'] = $value[7];
			$data['data'][$key]['time'] = $value[8];
		}
		$data['status'] = 1;
	}
	/*var_dump(count($res_arr)!=0);
	die();*/
}
echo json_encode($data);
