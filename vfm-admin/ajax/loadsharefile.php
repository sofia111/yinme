
<?php
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
/**
 * @File:	loadsharefile.php
 * @Author: Sofia
 * @Email:  1506798421@qq.com
 * @Date:	2018-10-18 16:30:33
 * @Comment: 公开分享文件
 */
require_once '../config.php';
/*
链接数据库
*/
$link=MySQL::getlink();

$data = [
	'status' => 1,
    'link' => pathinfo($_CONFIG['starting_dir'], PATHINFO_BASENAME),
	'msg' => ""
];
$keyword = $_POST['keyword'];/*and user = 'test'*/
$sql=mysqli_query($link,"select * from `p_file` where `share` = '1'  and filename like '%".$keyword."%' order by time desc");
	
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

echo json_encode($data);

