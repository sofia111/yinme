<?php

if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
// echo "<meta charset='utf-8'>";
if ($_POST['schoolName']) {
    $link = MySQL::getlink();
	$schoolName = urldecode($_POST['schoolName']);
	
    $sql=mysqli_query($link,"select distinct(`academyName`) from school where `schoolName`='{$schoolName}'");
    
    $result= mysqli_num_rows($sql);
    for ($i=0; $i < $result; $i++) { 
    	$data['academy'][] = mysqli_fetch_array($sql);
    }

    $data['status'] = 1;
    echo json_encode($data);
}