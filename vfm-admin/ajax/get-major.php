<?php
if (file_exists('../include/mysql/MySQL.class.php')) {
    require '../include/mysql/MySQL.class.php';
}
// echo "<meta charset='utf-8'>";
if ($_POST['academyName'] && $_POST['schoolName']) {
    $schoolName = urldecode($_POST['schoolName']);
	$academyName = urldecode($_POST['academyName']);
	$link=MySQL::getlink();
    $sql=mysqli_query($link,"select distinct(`majorName`) from school where `schoolName`='{$schoolName}' and `academyName`='{$academyName}'");
    
    $result = mysqli_num_rows($sql);
    for ($i=0; $i < $result; $i++) { 
    	$data['major'][] = mysqli_fetch_array($sql);
    }

    $data['status'] = 1;
    echo json_encode($data);
}