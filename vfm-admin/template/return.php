<?php

/**
 * @File:   return.php
 * @Author: Alan_Albert
 * @Email:  1766447919@qq.com
 * @Date:   2018-07-17 11:09:55
 * @Last Modified by:   Alan_Albert
 * @Last Modified time: 2018-07-19 10:13:46
 * @Comment: 同步回调通知页面 (需商户在下单请求中传递Return_url)
 */

if (!$_POST) echo "<script>location.href='index.php'</script>";
if (file_exists('vfm-admin/include/ispay/Ispay.class.php'))
    require 'vfm-admin/include/ispay/Ispay.class.php';
if (file_exists('vfm-admin/users/config.php'))
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
if(!$Ispay->callbackSignCheck($Array)){
    $html = <<<HTML
    <h2 class='text-center'>签名失败，2s后跳转...</h2>
    <script>
        setTimeout(function(){
            location.href='yinme.php';
        }, 2000);
    </script>
HTML;
    echo $html;
    exit;
}
?>
        <div >
            <div class="page msg">
                <div class="bd">
                    <div class="weui_msg" style="padding: 10px 0 0;">
                        <div class="text-center">
                            <h2>付款成功，支付<?php echo $Array['Money']/100; ?> 元</h2>
                            <h3>稍后跳转到订单状态...</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 
	if(isset($_SESSION['yinbi'])){
	if (file_exists('../include/mysql/MySQL.class.php')) {
	require '../include/mysql/MySQL.class.php';
	}
	$conn=MySQL::getlink();
    $sql = "update user set invitation = ".$_SESSION['yinbi']." where userName = '".$_SESSION['vfm_user_name']."'";
    $conn->query($sql);
	unset($_SESSION['yinbi']);
	}
	 if(isset($_SESSION['off_pagenum'])){
        $conn=MySQL::getlink();
    $sql = "update user set orders = orders + 1,pages = pages + ".$_SESSION['off_pagenum']." where userName = '".$_SESSION['vfm_user_name']."'";
    $conn->query($sql);
        unset($_SESSION['off_pagenum']);
    }
    if(isset($_SESSION['getisfirstpage'])){
        $conn=MySQL::getlink();
    $sql = "update user set isfirstpage = 0 where userName = '".$_SESSION['vfm_user_name']."'";
    $conn->query($sql);
        unset($_SESSION['off_pagenum']);
    }
?>
        <script type="text/javascript">
            setTimeout(function(){
                location.href='yinme.php?order';
            }, 2000);
        </script>