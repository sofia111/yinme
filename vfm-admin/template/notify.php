<?php
 header("Content-Type: text/html; charset=UTF-8");
error_reporting(0);


	require_once "vfm-admin/temeplate/lib/config.php";
    require_once "vfm-admin/temeplate/lib/Log.class.php";
    require_once "vfm-admin/temeplate/lib/Epay.class.php";  

    $EpayClient = new EpayClientAop($config);
    $LogClient  = new LogClientAop();

    /****接收对应参数通知****/
    $result = $EpayClient->acceptNotify($config);

    /****记录支付成功结果记录****/
    $LogClient->reply_log($result);

    /****将支付结果写到支付文件中方便提现SDK支付成功后的一个方法*****/
    $LogClient->success_log($result["out_trade_no"]);

    /***************
    *
    *


    * 执行您的业务逻辑
    *
    *
    *
    ****************/
     $data[':order'] = filter_input(INPUT_POST, 'order_no', FILTER_SANITIZE_STRING);
    $data[':is_temp'] = 0;

    $mysql_conn = MySQL::getConn();
    $sql = "UPDATE print 
        SET is_temp=:is_temp 
        WHERE `order`=:order";
    $stmt = $mysql_conn->prepare($sql);
    if (!$stmt->execute($data)) {
        echo "update fail!";
        die();
    }
    if(isset($_SESSION['off_pagenum'])){
        $query_data[':off_pagenum'] = $_SESSION['off_pagenum'];
        $query_data[':userName'] = $_SESSION['vfm_user_name'];
        $sql = "UPDATE user SET `orders` = `orders` + 1,`pages` = `pages`+ :off_pagenum WHERE `userName` = :userName";
        $stmt = $mysql_conn->prepare($sql);
        if (!$stmt->execute($query_data)) {
            echo "update fail!";
            die();
        }
        unset($_SESSION['off_pagenum']);
    }

    echo "success";exit;        //返回服务器已成功通知
 
?>