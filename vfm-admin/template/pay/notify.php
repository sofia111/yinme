<?php

/**
 * @File:   notify.php
 * @Author: Alan_Albert
 * @Email:  1766447919@qq.com
 * @Date:   2018-07-17 11:09:43
 * @Last Modified by:   Alan_Albert
 * @Last Modified time: 2018-07-18 18:37:54
 * @Comment: 异步回调通知页面 (需商户在下单请求中传递Notify_url)
 */
if (!$_POST || !$_GET) {
    echo "<script>location.href='yinme.php'</script>";
    die();
}
if (!defined('PAY_INC') && file_exists('vfm-admin/include/ispay/Ispay.class.php'))
    require 'vfm-admin/include/ispay/Ispay.class.php';
if (!defined('SQL_INC') && file_exists('vfm-admin/include/mysql/MySQL.class.php'))
    require 'vfm-admin/include/mysql/MySQL.class.php';
if (!defined('CFG_INC') && file_exists('vfm-admin/users/config.php'))
    require 'vfm-admin/users/config.php';

$Ispay = new ispayService($config['payId'], $config['payKey']);
//设置时区
date_default_timezone_set('Asia/Shanghai');
//接受ISPAY通知返回的支付渠道
$Array['payChannel'] = $_POST['payChannel']; //(支付通道)
//接受ISPAY通知返回的支付金额
$Array['Money'] = $_POST['Money'];  //(单位分)
//接受ISPAY通知返回的订单号
$Array['orderNumber'] = $_POST['orderNumber'];  //(商户订单号)
//接受ISPAY通知返回的附加数据
$Array['attachData'] = $_POST['attachData'];  //(商户自定义附加数据)
//接受ISPAY通知返回的回调签名
$Array['callbackSign'] = $_POST['callbackSign'];  //(详情查看ISPAY开发文档)
//回调签名校验
if($Ispay->callbackSignCheck($Array)){
    //回调请求校验  (有效预防商户泄露payKey导致回调签名遭到破解的另一种校验方式,弊端会影响回调的成功率,要求安全性建议开启。) 开启请将下方注释//去掉
    //if(!$Ispay->callbackRequestCheck($Array)){echo "fail!";exit;}
    //<--------------------------商户业务代码写在下方-------------------------->
    // 根据ID取数据库临时订单信息
    $data[':order'] = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
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
    //<--------------------------商户业务代码写在上方-------------------------->
    //下方输出是告知ISPAY服务器业务受理成功,请不要修改下方输出内容,否则会导致重复通知,ISPAY服务器会在24小时内通知8次,输出SUCCESS则不再进行通知
    echo "SUCCESS";
}else{
    echo "callbackSign fail!";
    exit;
}
