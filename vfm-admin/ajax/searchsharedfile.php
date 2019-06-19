
<?php
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
/**
 * @File:	searchsharedfile.php
 * @Author: Sofia
 * @Email:  1506798421@qq.com
 * @Date:	2018-07-27 16:30:33
 * @Comment: 搜索已分享文件
 */
require_once '../config.php';
/*
链接数据库
*/
$link=MySQL::getlink();

$data = [
	'status' => 123,
    'link' => pathinfo($_CONFIG['starting_dir'], PATHINFO_BASENAME),
	'msg' => ""
];

if (isset($_POST['searchschool']) && isset($_POST['searchmajor'])) {
	$searchschool = urldecode($_POST['searchschool']);
	$searchmajor = urldecode($_POST['searchmajor']);
	$keyword = urldecode($_POST['keyword']);
	if ($searchschool =='0' && $searchmajor =='0' && $keyword ==null) { 
		$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' order by time desc");
	}
    else if ($searchschool =='0' && $searchmajor =='0' && $keyword !=null) {
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and filename like '%".$keyword."%' order by time desc");
    }
    else if ($searchschool !='0' && $searchmajor =='0' &&  $keyword !=null) {
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and school ='".$searchschool."' and filename = '%".$keyword."%' order by time desc");
    }
    else if ($searchschool !='0' && $searchmajor =='0' &&  $keyword ==null) {
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and school ='".$searchschool."' order by time desc");
    }
    else if ($searchschool =='0' && $searchmajor !='0' &&  $keyword !=null) {
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and major ='".$searchmajor."' and filename = '%".$keyword."%' order by time desc");
    }
    else if ($searchschool =='0' && $searchmajor !='0' &&  
        $keyword ==null) {
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and major ='".$searchmajor."' order by time desc");
    }
    else if ($searchschool !='0' && $searchmajor !='0' &&  $keyword !=null) {
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and school ='".$searchschool."' and filename = '%".$keyword."%' and major ='".$searchmajor."' order by time desc");
    }
    else if ($searchschool !='0' && $searchmajor !='0' &&  $keyword == null){
    	$sql=mysqli_query($link,"select * from `p_file` where `share` = '1' and school ='".$searchschool."' and major ='".$searchmajor."' order by time desc");
    }
    $result = mysqli_num_rows($sql);
	if ($result) {
        $data['status'] = 1;
        for ($i = 0; $i < $result; $i++) {
		    $info = mysqli_fetch_array($sql);
            $data['data'][$i]['username'] = $info['user'];
            $data['data'][$i]['filename'] = $info['filename'];
            $data['data'][$i]['time'] = $info['time'];
            $data['data'][$i]['preview'] = $info['preview'];
            $data['data'][$i]['ext'] = pathinfo($info['filename'], PATHINFO_EXTENSION);
        }
		
	}
	else{
		$data['status'] = 0;
       
	}
}
echo json_encode($data);

